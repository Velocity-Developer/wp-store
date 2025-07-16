<?php

add_action('wp_footer', function () {
?>
  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.store('cart', {
        total_qty: 0,
        total_price: 0
      });
    });
  </script>
<?php
});
