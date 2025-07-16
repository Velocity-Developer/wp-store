<?php

add_shortcode('wp_store_cart_badge', 'wp_store_shortcode_cart_badge');

function wp_store_shortcode_cart_badge($atts)
{
  ob_start(); ?>
  <div id="wp-store-cart-badge" x-data class="cart-badge-wrapper">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-basket-icon lucide-shopping-basket">
      <path d="m15 11-1 9" />
      <path d="m19 11-4-7" />
      <path d="M2 11h20" />
      <path d="m3.5 11 1.6 7.4a2 2 0 0 0 2 1.6h9.8a2 2 0 0 0 2-1.6l1.7-7.4" />
      <path d="M4.5 15.5h15" />
      <path d="m5 11 4-7" />
      <path d="m9 11 1 9" />
    </svg>
    <span class="badge bg-danger" x-show="$store.cart.total_qty" x-text="$store.cart.total_qty || 0"></span>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const el = document.getElementById('wp-store-cart-badge');
      if (!el || !window.Alpine || !Alpine.store('cart')) return;
      fetch(`${wpStoreData.rest_url}wpstore/v1/cart/get`, {
          headers: {
            'X-WP-Nonce': wpStoreData.nonce
          }
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            Alpine.store('cart').total_qty = data.data.total_qty;
            Alpine.store('cart').total_price = data.data.total_price;
          }
        });
    });
  </script>
<?php
  return ob_get_clean();
}
