<?php
// Exit if accessed directly
if (! defined('ABSPATH')) {
  exit;
}

// 🔹 Daftar file yang akan diload
$includes = [
  // Utility & Checks
  'includes/checks.php',

  // Admin
  'includes/admin/enqueue.php',

  // Post Types
  'includes/post-types/product.php',

  // REST API
  'includes/rest/product-endpoints.php',
  'includes/rest/cart/add.php',
  'includes/rest/cart/get.php',

  // Helper
  'includes/helper/rest.php',
  'includes/helper/store.php',

  // Shortcodes
  'includes/shortcodes/cart/add.php',
  'includes/shortcodes/cart/badge.php',

  // Meta Fields (produk)
  'includes/meta/product-fields.php',

  // Frontend Assets
  'includes/enqueue.php',

  // Database Tables
  'includes/database/order.php',
  'includes/database/cart.php',

  // Custom Fields
  'includes/fields/opsi-warna.php',
  'includes/fields/opsi-produk.php',
  'includes/fields/opsi-variant.php',
];

// 🔹 Load semua file
foreach ($includes as $file) {
  require_once WP_STORE_PLUGIN_DIR . $file;
}

// 🔹 Register custom Meta Box field types
add_filter('rwmb_field_types', function ($types) {
  return array_merge($types, [
    'opsi_warna',
    'opsi_produk',
    'variant',
  ]);
});
