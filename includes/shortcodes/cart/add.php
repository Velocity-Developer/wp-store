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
  <div x-data="addToCartWithVariant(<?php echo esc_attr($product_id) ?>, JSON.parse('<?php echo $encoded ?>'))">
    <span><?php echo esc_attr($product_id) ?></span>
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
      :disabled="loading || success || (showVariants && (!selectedWarna || !selectedUkuran))">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart-icon lucide-shopping-cart">
        <circle cx="8" cy="21" r="1" />
        <circle cx="19" cy="21" r="1" />
        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
      </svg>
    </button>

    <template x-if="success">
      <span class="text-success ms-2">✓ Ditambahkan!</span>
    </template>
  </div>
<?php
  return ob_get_clean();
}
