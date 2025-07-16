<?php

function wp_store_create_cart_tables()
{
  global $wpdb;
  $charset = $wpdb->get_charset_collate();
  $prefix  = $wpdb->prefix;

  require_once ABSPATH . 'wp-admin/includes/upgrade.php';

  // Tabel utama cart
  dbDelta("
    CREATE TABLE {$prefix}store_cart (
      id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      user_id BIGINT UNSIGNED DEFAULT NULL,
      session_id VARCHAR(64) DEFAULT NULL,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
      updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      UNIQUE KEY uniq_user_session (user_id, session_id)
    ) ENGINE=InnoDB $charset;
  ");

  // Tabel item di dalam cart
  dbDelta("
    CREATE TABLE {$prefix}store_cart_items (
      id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      cart_id BIGINT UNSIGNED NOT NULL,
      product_id BIGINT UNSIGNED NOT NULL,
      qty INT UNSIGNED DEFAULT 1,
      opsi VARCHAR(255) DEFAULT NULL,
      added_at DATETIME DEFAULT CURRENT_TIMESTAMP,
      FOREIGN KEY (cart_id) REFERENCES {$prefix}store_cart(id) ON DELETE CASCADE
    ) ENGINE=InnoDB $charset;
  ");
}
