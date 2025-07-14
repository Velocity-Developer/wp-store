<?php

/**
 * Register meta boxes for product post type.
 *
 * @package WP Store by Velocity Developer
 */

// Exit if accessed directly
if (! defined('ABSPATH')) {
  exit;
}

// Cegah error jika plugin Meta Box belum aktif
if (! defined('RWMB_VER')) {
  return;
}

add_filter('rwmb_meta_boxes', 'wp_store_register_product_meta_boxes');
function wp_store_register_product_meta_boxes($meta_boxes)
{
  $site_title = get_bloginfo('name');
  $site_title = str_replace(' ', '', $site_title);
  $site_title = strtoupper(substr($site_title, 0, 3));
  $sku = $site_title . rand(1000000, 9999999);

  $meta_boxes[] = [
    'id'         => 'product-details',
    'title'      => __('Detail Produk', 'wp-store'),
    'post_types' => ['product'],
    'context'    => 'normal',
    'priority'   => 'high',
    'autosave'   => true,
    'fields'     => [

      // === GENERAL ===
      [
        'type' => 'heading',
        'name' => __('General', 'wp-store'),
      ],
      [
        'name'        => 'Label Produk',
        'id'          => 'label',
        'type'        => 'select_advanced',
        'options'     => [
          'label-best'    => 'Best Seller',
          'label-limited' => 'Limited',
          'label-new'     => 'New',
        ],
        'multiple'    => false,
        'placeholder' => 'Pilih Label',
      ],
      [
        'name' => 'Kode Produk (SKU)',
        'id'   => 'sku',
        'type' => 'text',
        'value' => $sku,
      ],
      [
        'name' => 'Harga (Rp)',
        'id'   => 'harga',
        'type' => 'number',
      ],
      [
        'name' => 'Harga Promo (Rp)',
        'id'   => 'harga_promo',
        'type' => 'number',
      ],
      [
        'name' => 'Minimal Order',
        'id'   => 'minorder',
        'type' => 'number',
      ],
      [
        'name'       => 'Diskon Sampai',
        'id'         => 'flashsale',
        'type'       => 'datetime',
        'timestamp'  => false,
        'js_options' => [
          'stepMinute'      => 1,
          'showTimepicker'  => true,
          'controlType'     => 'select',
          'showButtonPanel' => false,
          'oneLine'         => true,
        ],
      ],

      // === PENGIRIMAN ===
      [
        'type' => 'heading',
        'name' => __('Pengiriman', 'wp-store'),
      ],
      [
        'name' => 'Berat Produk (Kg)',
        'id'   => 'berat',
        'type' => 'number',
        'step' => '0.01',
        'desc' => 'Contoh: 1, 2, 3 (kg) atau 0.1, 0.5, 1.5 (gram)',
      ],

      // === STOK ===
      [
        'type' => 'heading',
        'name' => __('Stok', 'wp-store'),
      ],
      [
        'name' => 'Jumlah Stok',
        'id'   => 'stok',
        'type' => 'number',
        'desc' => 'Stok akan dikurangi setiap order. Tombol beli akan nonaktif jika stok 0.',
      ],

      // === GALERI ===
      [
        'type' => 'heading',
        'name' => __('Gallery', 'wp-store'),
      ],
      [
        'name'         => 'Gallery Produk',
        'id'           => 'gallery',
        'type'         => 'image_advanced',
        'force_delete' => false,
      ],

      // === OPSI BASIC ===
      [
        'type' => 'heading',
        'name' => __('Opsi Basic', 'wp-store'),
        'desc' => 'Opsi tanpa perubahan harga',
      ],
      [
        'name' => 'Nama Opsi',
        'id'   => 'namaopsi',
        'type' => 'text',
        'desc' => 'Contoh: "Pilih Warna"',
      ],
      [
        'name'  => 'Daftar Opsi',
        'id'    => 'opsistandart',
        'type'  => 'opsi_produk',
        'clone' => true,
      ],

      // === OPSI ADVANCE ===
      [
        'type' => 'heading',
        'name' => __('Opsi Advance', 'wp-store'),
        'desc' => 'Opsi dengan pengaruh harga',
      ],
      [
        'name' => 'Opsi Warna',
        'id'   => 'opsi_harga',
        'type' => 'opsi_warna',
        'desc' => 'Contoh: "Pilih Ukuran"',
      ],
    ],
  ];

  return $meta_boxes;
}
