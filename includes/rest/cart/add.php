<?php

add_action('rest_api_init', function () {
  register_rest_route('wpstore/v1', '/cart/add', [
    'methods'  => 'POST',
    'callback' => 'wp_store_rest_cart_add',
    'permission_callback' => '__return_true', // Public access
  ]);
});

function wp_store_rest_cart_add($request)
{
  global $wpdb;

  $product_id = intval($request->get_param('product_id'));
  $qty        = max(1, intval($request->get_param('qty')));
  $opsi_raw   = $request->get_param('opsi');
  $opsi       = is_null($opsi_raw) ? '' : sanitize_text_field($opsi_raw);

  if (! $product_id) {
    return new WP_Error('missing_product', 'Produk tidak valid.', ['status' => 400]);
  }

  $user_id    = get_current_user_id();
  $session_id = wp_store_get_session_id();

  $cart = wp_store_get_or_create_cart($user_id, $session_id);
  $cart_id = $cart->id;

  // Cek apakah item dengan opsi sama sudah ada
  $existing = $wpdb->get_row($wpdb->prepare(
    "SELECT * FROM {$wpdb->prefix}store_cart_items
   WHERE cart_id = %d AND product_id = %d AND opsi = %s",
    $cart_id,
    $product_id,
    $opsi
  ));

  if ($existing) {
    $wpdb->update(
      "{$wpdb->prefix}store_cart_items",
      ['qty' => $existing->qty + $qty],
      ['id' => $existing->id],
      ['%d'],
      ['%d']
    );
  } else {
    $wpdb->insert("{$wpdb->prefix}store_cart_items", [
      'cart_id'    => $cart_id,
      'product_id' => $product_id,
      'qty'        => $qty,
      'opsi'       => $opsi,
    ], ['%d', '%d', '%d', '%s']);
  }

  return rest_ensure_response([
    'success' => true,
    'message' => 'Item ditambahkan ke keranjang.',
  ]);
}
