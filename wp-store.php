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
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * Network: false
 */

// Exit if accessed directly
if (! defined('ABSPATH')) {
  exit;
}

// Prevent multiple plugin instances
if (defined('WP_STORE_VERSION')) {
  return;
}

// Define constants
define('WP_STORE_VERSION', '1.0.0');
define('WP_STORE_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WP_STORE_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WP_STORE_PLUGIN_FILE', __FILE__);
define('WP_STORE_PLUGIN_BASENAME', plugin_basename(__FILE__));

// Check PHP version compatibility
if (version_compare(PHP_VERSION, '7.4', '<')) {
  add_action('admin_notices', function () {
    echo '<div class="notice notice-error"><p>';
    echo sprintf(
      __('WP Store requires PHP version 7.4 or higher. You are running version %s.', 'wp-store'),
      PHP_VERSION
    );
    echo '</p></div>';
  });
  return;
}

// Check WordPress version compatibility
global $wp_version;
if (version_compare($wp_version, '5.0', '<')) {
  add_action('admin_notices', function () {
    echo '<div class="notice notice-error"><p>';
    echo sprintf(
      __('WP Store requires WordPress version 5.0 or higher. You are running version %s.', 'wp-store'),
      $GLOBALS['wp_version']
    );
    echo '</p></div>';
  });
  return;
}

// Register activation and deactivation hooks
register_activation_hook(__FILE__, 'wp_store_activate');
register_deactivation_hook(__FILE__, 'wp_store_deactivate');
register_uninstall_hook(__FILE__, 'wp_store_uninstall');

/**
 * Plugin activation hook
 */
function wp_store_activate()
{
  // Create database tables, add default options, etc.
  do_action('wp_store_activate');

  // Flush rewrite rules
  flush_rewrite_rules();
}

/**
 * Plugin deactivation hook
 */
function wp_store_deactivate()
{
  // Clean up temporary data, clear scheduled events, etc.
  do_action('wp_store_deactivate');

  // Flush rewrite rules
  flush_rewrite_rules();
}

/**
 * Plugin uninstall hook
 */
function wp_store_uninstall()
{
  // Remove all plugin data, options, database tables, etc.
  do_action('wp_store_uninstall');
}

// Bootstrap plugin
require_once WP_STORE_PLUGIN_DIR . 'includes/init.php';
