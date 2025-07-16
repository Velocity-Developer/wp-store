<?php

add_action('rest_api_init', function () {
  register_rest_route('wpstore/v1', '/cart/get', [
    'methods' => 'GET',
    'callback' => 'wp_store_rest_cart_get',
    'permission_callback' => '__return_true',
  ]);
});

function wp_store_rest_cart_get($request)
{
  global $wpdb;
  $prefix = $wpdb->prefix;

  // Ambil cart (berdasarkan user_id atau session_id)
  $cart = wp_store_get_or_create_cart(); // gunakan fungsi helper seperti sebelumnya

  if (! $cart) {
    return rest_ensure_response([
      'success' => true,
      'data' => [
        'total_qty' => 0,
        'total_price' => 0,
      ]
    ]);
  }

  // Ambil item dari store_cart_items
  $items = $wpdb->get_results($wpdb->prepare(
    "SELECT ci.qty, pm.meta_value AS price
FROM {$prefix}store_cart_items ci
LEFT JOIN {$wpdb->postmeta} pm ON pm.post_id = ci.product_id AND pm.meta_key = 'harga'
WHERE ci.cart_id = %d",
    $cart->id
  ));

  $total_qty = 0;
  $total_price = 0;

  foreach ($items as $item) {
    $price = str_replace('.', '', $item->price);
    $qty = (int) $item->qty;
    $price = (int) $price;
    $total_qty += $qty;
    $total_price += ($qty * $price);
  }

  return rest_ensure_response([
    'success' => true,
    'data' => [
      'total_qty' => $total_qty,
      'total_price' => $total_price,
    ],
    'raw_data' => $items
  ]);
}
