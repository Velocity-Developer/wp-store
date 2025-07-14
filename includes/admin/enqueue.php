<?php
add_action('admin_enqueue_scripts', 'wp_store_enqueue_admin_scripts');
function wp_store_enqueue_admin_scripts($hook)
{
  // Pastikan ini hanya dijalankan di halaman edit post product
  $screen = get_current_screen();
  if (! $screen || $screen->post_type !== 'product' || $screen->base !== 'post') {
    return;
  }

  // Enqueue AlpineJS jika belum ada
  if (! wp_script_is('alpinejs', 'enqueued')) {
    wp_enqueue_script(
      'alpinejs',
      'https://unpkg.com/alpinejs@3.13.5/dist/cdn.min.js',
      [],
      '3.13.5',
      true
    );
  }

  // Enqueue custom JS
  wp_enqueue_script(
    'wp-store-admin-fields',
    WP_STORE_PLUGIN_URL . 'assets/js/admin-fields.js',
    ['alpinejs'], // agar pasti load setelah alpine
    '1.0.0',
    true
  );

  // Localize data prefix
  $site_title = get_bloginfo('name');
  $prefix = strtoupper(substr(str_replace([' ', '-'], '', $site_title), 0, 3));

  wp_localize_script('wp-store-admin-fields', 'wpStoreSku', [
    'sitePrefix' => $prefix,
  ]);
}
