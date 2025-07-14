<?php
// Cek apakah plugin Meta Box aktif, jika tidak tampilkan notifikasi
add_action('admin_notices', 'wp_store_check_metabox_plugin');
function wp_store_check_metabox_plugin()
{
  // Hanya tampil di area admin dan untuk user dengan akses plugin
  if (is_admin() && current_user_can('activate_plugins') && ! defined('RWMB_VER')) {
    $plugin_slug = 'meta-box/meta-box.php';
    $install_url = wp_nonce_url(
      self_admin_url('update.php?action=install-plugin&plugin=meta-box'),
      'install-plugin_meta-box'
    );

    echo '<div class="notice notice-warning is-dismissible">';
    echo '<h3><strong>WP Store membutuhkan plugin <em>Meta Box</em></strong></h3>';
    echo '<p>Plugin <em>Meta Box</em> belum terpasang atau aktif. Plugin ini dibutuhkan untuk mengelola custom field produk seperti harga dan stok.</p>';

    // Jika plugin tersedia tapi tidak aktif
    if (file_exists(WP_PLUGIN_DIR . '/' . $plugin_slug)) {
      $activate_url = wp_nonce_url(
        self_admin_url('plugins.php?action=activate&plugin=' . $plugin_slug),
        'activate-plugin_' . $plugin_slug
      );
      echo '<p><a href="' . esc_url($activate_url) . '" class="button-primary">Aktifkan Meta Box</a></p>';
    } else {
      // Plugin belum ada, tawarkan install
      echo '<p><a href="' . esc_url($install_url) . '" class="button-primary">Install Meta Box</a></p>';
    }

    echo '</div>';
  }
}
