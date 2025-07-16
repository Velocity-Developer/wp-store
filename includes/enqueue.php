<?php
add_action('wp_enqueue_scripts', 'wp_store_enqueue_scripts');

function wp_store_enqueue_scripts()
{
  // Enqueue AlpineJS jika belum ada
  if (!wp_script_is('alpinejs', 'enqueued')) {
    wp_enqueue_script(
      'alpinejs',
      'https://unpkg.com/alpinejs@3.13.5/dist/cdn.min.js',
      [],
      '3.13.5',
      true
    );
  }

  // Enqueue cart-add.js SELALU
  wp_enqueue_script(
    'cart-add',
    WP_STORE_PLUGIN_URL . 'assets/js/cart-add.js',
    ['alpinejs'],
    filemtime(WP_STORE_PLUGIN_DIR . 'assets/js/cart-add.js'),
    true
  );

  // Enqueue script utama (yang mengandung x-data)
  wp_enqueue_script(
    'wp-store-script',
    WP_STORE_PLUGIN_URL . 'assets/js/wp-store.js',
    ['alpinejs'],
    filemtime(WP_STORE_PLUGIN_DIR . 'assets/js/wp-store.js'),
    true
  );

  // Localize data
  wp_localize_script('wp-store-script', 'wpStoreData', [
    'nonce'    => wp_create_nonce('wp_rest'),
    'rest_url' => esc_url_raw(rest_url()),
  ]);
}
