<?php

/**
 * Plugin Name: WP Store
 * Plugin URI: https://velocitydeveloper.com/wp-store
 * Description: Plugin toko online sederhana berbasis REST API dengan integrasi frontend menggunakan Alpine.js dan Bootstrap 5.
 * Version: 1.0.0
 * Author: Velocity Developer Team
 * Author URI: https://velocitydeveloper.com
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-store
 * Domain Path: /languages
 */

// Exit if accessed directly
if (! defined('ABSPATH')) {
  exit;
}

// Define constants
define('WP_STORE_VERSION', '1.0.0');
define('WP_STORE_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WP_STORE_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WP_STORE_PLUGIN_FILE', __FILE__);

// Bootstrap plugin (kamu bisa include file init, cpt, rest api, dsb di sini)
require_once WP_STORE_PLUGIN_DIR . 'includes/init.php';
