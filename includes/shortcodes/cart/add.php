<?php

add_shortcode('wp_store_add_to_cart', 'wp_store_shortcode_add_to_cart');

function wp_store_shortcode_add_to_cart($atts)
{
  $atts = shortcode_atts([
    'product_id' => get_the_ID(),
    'label'      => 'Tambah ke Keranjang',
  ], $atts, 'wp_store_add_to_cart');

  $product_id = (int) $atts['product_id'];
  $variants   = get_post_meta($product_id, 'opsi', true);
  $has_variant = is_array($variants) && count($variants) > 0;

  // Kirim ke JS sebagai JSON
  wp_add_inline_script('wp-store-script', 'window.wpStoreVariants = ' . json_encode($variants ?: []) . ';', 'before');

  ob_start(); ?>

  <?php $encoded = esc_attr(json_encode($variants ?: [])); ?>
  <div x-data="addToCartWithVariant(<?= esc_attr($product_id) ?>, <?= $encoded ?>)">
    <template x-if="variants.length">
      <div class="mb-3">
        <label>Warna</label>
        <select x-model="selectedWarna" class="form-select mb-2">
          <option value="">Pilih Warna</option>
          <template x-for="v in variants" :key="v.label">
            <option :value="v.label" x-text="v.label"></option>
          </template>
        </select>

        <template x-if="filteredSizes.length">
          <div>
            <label>Ukuran</label>
            <select x-model="selectedUkuran" class="form-select">
              <option value="">Pilih Ukuran</option>
              <template x-for="size in filteredSizes" :key="size.ukuran">
                <option :value="size.ukuran" x-text="size.ukuran + ' (' + size.stok + ' stok)'"></option>
              </template>
            </select>
          </div>
        </template>
      </div>
    </template>

    <button type="button"
      @click="addToCart"
      x-text="loading ? 'Menambahkan...' : '<?php echo esc_js($atts['label']) ?>'"
      class="btn btn-primary"
      :disabled="loading || success || (variants.length && (!selectedWarna || !selectedUkuran))"></button>

    <template x-if="success">
      <span class="text-success ms-2">✓ Ditambahkan!</span>
    </template>
  </div>
  <script>
    function addToCartWithVariant(productId, initialVariants = []) {
      return {
        variants: initialVariants,
        selectedWarna: '',
        selectedUkuran: '',
        loading: false,
        success: false,

        get filteredSizes() {
          const selected = this.variants.find(v => v.label === this.selectedWarna);
          return selected ? selected.items : [];
        },

        get opsiText() {
          return this.selectedWarna && this.selectedUkuran ?
            `Warna: ${this.selectedWarna} | Ukuran: ${this.selectedUkuran}` :
            '';
        },

        addToCart() {
          this.loading = true;
          fetch(`${wpStoreData.rest_url}wpstore/v1/cart/add`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': wpStoreData.nonce,
              },
              body: JSON.stringify({
                product_id: productId,
                qty: 1,
                opsi: this.opsiText,
              })
            })
            .then(res => res.json())
            .then(data => {
              if (data.success) this.success = true;
              else alert(data.message || 'Gagal menambahkan ke keranjang.');
            })
            .catch(err => {
              console.error(err);
              alert('Terjadi kesalahan.');
            })
            .finally(() => {
              this.loading = false;
            });
        }
      }
    }
  </script>
<?php return ob_get_clean();
}
