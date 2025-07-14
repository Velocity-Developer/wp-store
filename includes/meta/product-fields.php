<?php
// Exit if accessed directly
if (! defined('ABSPATH')) {
  exit;
}

add_filter('rwmb_meta_boxes', 'wp_store_register_product_meta_boxes');
function wp_store_register_product_meta_boxes($meta_boxes)
{
  $meta_boxes[] = [
    'id'         => 'product-details',
    'title'      => __('Detail Produk', 'wp-store'),
    'post_types' => ['product'],
    'context'    => 'normal',
    'priority'   => 'high',
    'autosave'   => true,
    'fields'     => [
      [
        'name' => __('Harga', 'wp-store'),
        'id'   => 'price',
        'type' => 'number',
        'step' => 'any',
        'min'  => 0,
        'suffix' => 'Rp',
      ],
      [
        'name' => __('Stok', 'wp-store'),
        'id'   => 'stock',
        'type' => 'number',
        'min'  => 0,
      ],
      [
        'name' => __('SKU', 'wp-store'),
        'id'   => 'sku',
        'type' => 'text',
      ],
      [
        'name' => __('Tampilkan Produk?', 'wp-store'),
        'id'   => 'visible',
        'type' => 'checkbox',
        'std'  => true,
      ],
    ],
  ];
  return $meta_boxes;
}
