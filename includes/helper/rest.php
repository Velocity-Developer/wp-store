<?php

/**
 * Ambil session_id dari cookie atau buat baru
 */
function wp_store_get_session_id()
{
  if (isset($_COOKIE['wp_store_session'])) {
    return sanitize_text_field($_COOKIE['wp_store_session']);
  }

  $session_id = wp_generate_uuid4();
  setcookie('wp_store_session', $session_id, time() + 30 * DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN);
  return $session_id;
}

/**
 * Ambil atau buat cart (store_cart.id)
 */
function wp_store_get_or_create_cart($user_id = null, $session_id = null)
{
  global $wpdb;
  $prefix = $wpdb->prefix;

  if (is_null($user_id) && is_user_logged_in()) {
    $user_id = get_current_user_id();
  }

  if (is_null($session_id) && ! $user_id) {
    $session_id = $_COOKIE['wp_store_session'] ?? wp_generate_uuid4();
    setcookie('wp_store_session', $session_id, time() + 30 * DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN);
  }

  if ($user_id) {
    $cart = $wpdb->get_row($wpdb->prepare(
      "SELECT * FROM {$prefix}store_cart WHERE user_id = %d AND session_id IS NULL",
      $user_id
    ));
  } else {
    $cart = $wpdb->get_row($wpdb->prepare(
      "SELECT * FROM {$prefix}store_cart WHERE user_id IS NULL AND session_id = %s",
      $session_id
    ));
  }

  if (! $cart) {
    $wpdb->insert("{$prefix}store_cart", [
      'user_id'    => $user_id,
      'session_id' => $user_id ? null : $session_id,
      'created_at' => current_time('mysql'),
      'updated_at' => current_time('mysql'),
    ]);
    $cart = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$prefix}store_cart WHERE id = %d", $wpdb->insert_id));
  }

  return $cart;
}
