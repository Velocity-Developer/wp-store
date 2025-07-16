<?php

function wp_store_create_tables()
{
  global $wpdb;
  $charset = $wpdb->get_charset_collate();
  $prefix  = $wpdb->prefix;

  require_once ABSPATH . 'wp-admin/includes/upgrade.php';

  // Tabel store_orders
  dbDelta("
    CREATE TABLE {$prefix}store_orders (
      id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      user_id BIGINT DEFAULT NULL,
      total BIGINT DEFAULT 0,
      status VARCHAR(50) DEFAULT 'pending',
      name VARCHAR(100) DEFAULT NULL,
      email VARCHAR(100) DEFAULT NULL,
      phone VARCHAR(20) DEFAULT NULL,
      payment_method VARCHAR(50) DEFAULT NULL,
      payment_attachment BIGINT DEFAULT NULL,
      address VARCHAR(255) DEFAULT NULL,
      subdistrict VARCHAR(255) DEFAULT NULL,
      district VARCHAR(255) DEFAULT NULL,
      city VARCHAR(255) DEFAULT NULL,
      province VARCHAR(255) DEFAULT NULL,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB $charset;
  ");

  // Tabel store_order_sub
  dbDelta("
    CREATE TABLE {$prefix}store_order_sub (
      id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      order_id BIGINT UNSIGNED NOT NULL,
      seller_id BIGINT UNSIGNED NOT NULL,
      total BIGINT DEFAULT 0,
      status VARCHAR(50) DEFAULT 'pending',
      resi VARCHAR(100) DEFAULT NULL,
      FOREIGN KEY (order_id) REFERENCES {$prefix}store_orders(id) ON DELETE CASCADE
    ) ENGINE=InnoDB $charset;
  ");

  // Tabel store_order_items
  dbDelta("
    CREATE TABLE {$prefix}store_order_items (
      id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      order_id BIGINT UNSIGNED NOT NULL,
      suborder_id BIGINT UNSIGNED DEFAULT NULL,
      product_id BIGINT UNSIGNED NOT NULL,
      seller_id BIGINT UNSIGNED NOT NULL,
      product_name VARCHAR(255) NOT NULL,
      qty INT UNSIGNED DEFAULT 1,
      price BIGINT DEFAULT 0,
      opsi VARCHAR(255) DEFAULT NULL,
      subtotal BIGINT DEFAULT 0,
      FOREIGN KEY (order_id) REFERENCES {$prefix}store_orders(id) ON DELETE CASCADE,
      FOREIGN KEY (suborder_id) REFERENCES {$prefix}store_order_sub(id) ON DELETE SET NULL
    ) ENGINE=InnoDB $charset;
  ");

  // Tabel store_order_itemmeta
  dbDelta("
    CREATE TABLE {$prefix}store_order_itemmeta (
      id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      item_id BIGINT UNSIGNED NOT NULL,
      meta_key VARCHAR(100) NOT NULL,
      meta_value LONGTEXT,
      FOREIGN KEY (item_id) REFERENCES {$prefix}store_order_items(id) ON DELETE CASCADE
    ) ENGINE=InnoDB $charset;
  ");

  // Tabel store_order_ongkir
  dbDelta("
    CREATE TABLE {$prefix}store_order_ongkir (
      id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      order_id BIGINT UNSIGNED NOT NULL,
      seller_id BIGINT UNSIGNED NOT NULL,
      shipping_cost BIGINT DEFAULT 0,
      kurir VARCHAR(100),
      service VARCHAR(255),
      resi VARCHAR(100) DEFAULT NULL,
      status VARCHAR(50) DEFAULT 'pending',
      FOREIGN KEY (order_id) REFERENCES {$prefix}store_orders(id) ON DELETE CASCADE
    ) ENGINE=InnoDB $charset;
  ");
}

register_activation_hook(__FILE__, 'wp_store_create_tables');
