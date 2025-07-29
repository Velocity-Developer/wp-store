<?php

/**
 * Admin page for WP Store Seeder
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

// Add admin menu
add_action('admin_menu', 'wp_store_seeder_admin_menu');

function wp_store_seeder_admin_menu()
{
  add_management_page(
    'WP Store Seeder',
    'WP Store Seeder',
    'manage_options',
    'wp-store-seeder',
    'wp_store_seeder_admin_page'
  );
}

function wp_store_seeder_admin_page()
{
?>
  <div class="wrap">
    <h1>WP Store Product Seeder</h1>

    <?php if (isset($_POST['run_seeder']) && wp_verify_nonce($_POST['seeder_nonce'], 'run_wp_store_seeder')) : ?>
      <div class="notice notice-info">
        <p>Running seeder... Please wait.</p>
      </div>

      <?php
      // Include seeder functions and run
      require_once WP_STORE_PLUGIN_DIR . 'includes/seeder-functions.php';
      wp_store_run_seeder();
      ?>

    <?php else : ?>
      <div class="notice notice-warning">
        <p><strong>Warning:</strong> This will create 50+ sample products in your database. Make sure you want to do this!</p>
      </div>

      <form method="post" action="">
        <?php wp_nonce_field('run_wp_store_seeder', 'seeder_nonce'); ?>
        <table class="form-table">
          <tr>
            <th scope="row">Seeder Information</th>
            <td>
              <p>This seeder will create:</p>
              <ul>
                <li><strong>6 Categories:</strong> Fashion, Electronics, Books, Sports, Home & Garden, Beauty</li>
                <li><strong>50+ Products:</strong> Mix of detailed sample products and generated products</li>
                <li><strong>Product Features:</strong> Prices, variants, stock, SKU, specifications</li>
                <li><strong>Realistic Data:</strong> Indonesian product names and pricing</li>
              </ul>
            </td>
          </tr>
        </table>

        <p class="submit">
          <input type="submit" name="run_seeder" class="button-primary"
            value="Run Product Seeder"
            onclick="return confirm('Are you sure you want to create sample products? This action cannot be undone easily.');">
        </p>
      </form>

      <hr>

      <h2>Clean Up</h2>
      <p>If you want to remove all seeded products later, you can:</p>
      <ol>
        <li>Go to <strong>Products > All Products</strong></li>
        <li>Select all products you want to delete</li>
        <li>Use bulk actions to move them to trash</li>
        <li>Go to <strong>Products > Categories</strong> to delete categories if needed</li>
      </ol>
    <?php endif; ?>
  </div>
<?php
}
?>