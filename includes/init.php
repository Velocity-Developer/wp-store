<?php
// Exit if accessed directly
if (! defined('ABSPATH')) {
  exit;
}

// Autoload includes
require_once WP_STORE_PLUGIN_DIR . 'includes/checks.php';
require_once WP_STORE_PLUGIN_DIR . 'includes/admin/enqueue.php';
require_once WP_STORE_PLUGIN_DIR . 'includes/post-types/product.php';
require_once WP_STORE_PLUGIN_DIR . 'includes/rest/product-endpoints.php';
require_once WP_STORE_PLUGIN_DIR . 'includes/meta/product-fields.php';

// custom field
require_once WP_STORE_PLUGIN_DIR . 'includes/fields/opsi-warna.php';
require_once WP_STORE_PLUGIN_DIR . 'includes/fields/opsi-produk.php';
require_once WP_STORE_PLUGIN_DIR . 'includes/fields/opsi-variant.php';

add_filter('rwmb_field_types', function ($types) {
  $types[] = 'opsi_warna';
  $types[] = 'opsi_produk';
  $types[] = 'variant';
  return $types;
});
