<?php
// Exit if accessed directly
if (! defined('ABSPATH')) {
  exit;
}

add_action('rest_api_init', function () {
  register_rest_field('product', 'price', [
    'get_callback' => function ($object) {
      return get_post_meta($object['id'], 'price', true);
    },
    'schema' => null,
  ]);

  register_rest_field('product', 'stock', [
    'get_callback' => function ($object) {
      return get_post_meta($object['id'], 'stock', true);
    },
    'schema' => null,
  ]);
});
