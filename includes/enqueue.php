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

  // Enqueue script lokal utama
  wp_enqueue_script(
    'wp-store-script', // handle
    plugin_dir_url(__FILE__) . 'assets/js/wp-store.js',
    ['alpinejs'], // depend on AlpineJS if needed
    filemtime(plugin_dir_path(__FILE__) . 'assets/js/wp-store.js'),
    true
  );

  // Localize REST data
  wp_localize_script('wp-store-script', 'wpStoreData', [
    'nonce'    => wp_create_nonce('wp_rest'),
    'rest_url' => esc_url_raw(rest_url()),
  ]);
}
