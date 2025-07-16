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
  $opsi       = sanitize_text_field($request->get_param('opsi'));

  if (! $product_id) {
    return new WP_Error('missing_product', 'Produk tidak valid.', ['status' => 400]);
  }

  $user_id    = get_current_user_id();
  $session_id = wp_store_get_session_id();

  $cart_id = wp_store_get_or_create_cart($user_id, $session_id);

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

/**
 * Ambil session_id dari cookie atau buat baru
 */
function wp_store_get_session_id()
{
  if (is_user_logged_in()) {
    return null; // Gunakan user_id saja
  }

  if (! session_id()) {
    session_start();
  }

  if (empty($_SESSION['wp_store_sid'])) {
    $_SESSION['wp_store_sid'] = bin2hex(random_bytes(16));
  }

  return $_SESSION['wp_store_sid'];
}

/**
 * Ambil atau buat cart (store_cart.id)
 */
function wp_store_get_or_create_cart($user_id, $session_id)
{
  global $wpdb;
  $table = $wpdb->prefix . 'store_cart';

  // Cari berdasarkan user_id atau session_id
  $cart = $wpdb->get_row($wpdb->prepare(
    "SELECT * FROM $table WHERE user_id = %d OR session_id = %s LIMIT 1",
    $user_id ?: 0,
    $session_id ?: ''
  ));

  if ($cart) return $cart->id;

  // Buat baru
  $wpdb->insert($table, [
    'user_id'    => $user_id ?: null,
    'session_id' => $session_id,
  ], ['%d', '%s']);

  return $wpdb->insert_id;
}
