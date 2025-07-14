<?php
// Exit if accessed directly
if (! defined('ABSPATH')) {
  exit;
}

add_action('init', 'wp_store_register_product_post_type');
function wp_store_register_product_post_type()
{
  register_post_type('product', [
    'labels' => [
      'name'               => __('Produk', 'wp-store'),
      'singular_name'      => __('Produk', 'wp-store'),
      'add_new'            => __('Tambah Produk', 'wp-store'),
      'add_new_item'       => __('Tambah Produk Baru', 'wp-store'),
      'edit_item'          => __('Edit Produk', 'wp-store'),
      'new_item'           => __('Produk Baru', 'wp-store'),
      'view_item'          => __('Lihat Produk', 'wp-store'),
      'search_items'       => __('Cari Produk', 'wp-store'),
      'not_found'          => __('Tidak ada produk ditemukan', 'wp-store'),
      'not_found_in_trash' => __('Tidak ada produk di tong sampah', 'wp-store'),
    ],
    'public'              => true,
    'show_in_menu'        => true,
    'menu_icon'           => 'dashicons-cart',
    'has_archive'         => true,
    'show_in_rest'        => true,
    'rewrite'             => ['slug' => 'produk'],
    'supports'            => ['title', 'editor', 'thumbnail'],
    'taxonomies'          => ['category', 'post_tag'],
    'capability_type'     => 'post',
  ]);
}
