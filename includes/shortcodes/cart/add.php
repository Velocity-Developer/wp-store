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
  $encoded    = esc_attr(json_encode($variants ?: []));

  ob_start(); ?>
  <div x-data="addToCartWithVariant(<?php echo esc_attr($product_id) ?>, <?php echo $encoded ?>)">
    <pre x-text="JSON.stringify(variants, null, 2)"></pre>
    <template x-if="showVariants">
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
      :disabled="loading || success || (showVariants && (!selectedWarna || !selectedUkuran))"></button>

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
            `Warna: ${this.selectedWarna} | Ukuran: ${this.selectedUkuran}` : '';
        },
        get showVariants() {
          return this.variants.length > 1;
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
              if (data.success) {
                this.success = true;
                this.updateCartStore();
              } else {
                alert(data.message || 'Gagal menambahkan ke keranjang.');
              }
            })
            .catch(err => {
              console.error(err);
              alert('Terjadi kesalahan.');
            })
            .finally(() => {
              this.loading = false;
            });
        },
        updateCartStore() {
          fetch(`${wpStoreData.rest_url}wpstore/v1/cart/get`, {
              headers: {
                'X-WP-Nonce': wpStoreData.nonce,
              }
            })
            .then(res => res.json())
            .then(data => {
              if (data.success) {
                Alpine.store('cart').total_qty = data.data.total_qty;
                Alpine.store('cart').total_price = data.data.total_price;
              }
            });
        }
      }
    }
  </script>
<?php
  return ob_get_clean();
}
