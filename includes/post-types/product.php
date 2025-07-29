<?php
// Exit if accessed directly
if (! defined('ABSPATH')) {
  exit;
}

add_action('init', 'wp_store_register_product_post_type');
function wp_store_register_product_post_type()
{
  // Register Product Post Type
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
    // 'rewrite'             => ['slug' => 'produk'],
    'supports'            => ['title', 'editor', 'thumbnail', 'excerpt'],
    'capability_type'     => 'post',
  ]);

  // Register Product Category Taxonomy
  register_taxonomy('product_category', 'product', [
    'labels' => [
      'name'              => __('Kategori Produk', 'wp-store'),
      'singular_name'     => __('Kategori Produk', 'wp-store'),
      'search_items'      => __('Cari Kategori', 'wp-store'),
      'all_items'         => __('Semua Kategori', 'wp-store'),
      'parent_item'       => __('Kategori Induk', 'wp-store'),
      'parent_item_colon' => __('Kategori Induk:', 'wp-store'),
      'edit_item'         => __('Edit Kategori', 'wp-store'),
      'update_item'       => __('Update Kategori', 'wp-store'),
      'add_new_item'      => __('Tambah Kategori Baru', 'wp-store'),
      'new_item_name'     => __('Nama Kategori Baru', 'wp-store'),
      'menu_name'         => __('Kategori', 'wp-store'),
    ],
    'hierarchical'        => true,
    'public'              => true,
    'show_ui'             => true,
    'show_admin_column'   => true,
    'query_var'           => true,
    'show_in_rest'        => true,
    'rewrite'             => ['slug' => 'kategori-produk'],
  ]);

  // Register Product Tag Taxonomy
  register_taxonomy('product_tag', 'product', [
    'labels' => [
      'name'                       => __('Tag Produk', 'wp-store'),
      'singular_name'              => __('Tag Produk', 'wp-store'),
      'search_items'               => __('Cari Tag', 'wp-store'),
      'popular_items'              => __('Tag Populer', 'wp-store'),
      'all_items'                  => __('Semua Tag', 'wp-store'),
      'edit_item'                  => __('Edit Tag', 'wp-store'),
      'update_item'                => __('Update Tag', 'wp-store'),
      'add_new_item'               => __('Tambah Tag Baru', 'wp-store'),
      'new_item_name'              => __('Nama Tag Baru', 'wp-store'),
      'separate_items_with_commas' => __('Pisahkan tag dengan koma', 'wp-store'),
      'add_or_remove_items'        => __('Tambah atau hapus tag', 'wp-store'),
      'choose_from_most_used'      => __('Pilih dari tag yang sering digunakan', 'wp-store'),
      'menu_name'                  => __('Tag', 'wp-store'),
    ],
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_admin_column'   => true,
    'query_var'           => true,
    'show_in_rest'        => true,
    'rewrite'             => ['slug' => 'tag-produk'],
  ]);
}
