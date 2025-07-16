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
<?php
  return ob_get_clean();
}
