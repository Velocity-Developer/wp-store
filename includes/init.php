<?php
// Exit if accessed directly
if (! defined('ABSPATH')) {
  exit;
}

// Autoload includes
require_once WP_STORE_PLUGIN_DIR . 'includes/post-types/product.php';
require_once WP_STORE_PLUGIN_DIR . 'includes/rest/product-endpoints.php';
require_once WP_STORE_PLUGIN_DIR . 'includes/meta/product-fields.php';
