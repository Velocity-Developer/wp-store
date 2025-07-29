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

  <script>
    function addToCart(productId, initialVariants = []) {
      return {
        variants: initialVariants,
        selectedWarna: '',
        selectedUkuran: '',
        loading: false,
        success: false,
        get filteredSizes() {
          const selected = this.variants.find(v => v.label === this.selectedWarna);
          return selected ? selected.items : [];
        },
        get opsiText() {
          return this.selectedWarna && this.selectedUkuran ?
            `Warna: ${this.selectedWarna} | Ukuran: ${this.selectedUkuran}` : '';
        },
        get showVariants() {
          return this.variants.length > 1;
        },
        addToCart() {
          this.loading = true;
          fetch(`${wpStoreData.rest_url}wpstore/v1/cart/add`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': wpStoreData.nonce,
              },
              body: JSON.stringify({
                product_id: productId,
                qty: 1,
                opsi: this.opsiText,
              })
            })
            .then(res => res.json())
            .then(data => {
              if (data.success) {
                this.success = true;
                this.updateCartStore();
              } else {
                alert(data.message || 'Gagal menambahkan ke keranjang.');
              }
            })
            .catch(err => {
              console.error(err);
              alert('Terjadi kesalahan.');
            })
            .finally(() => {
              this.loading = false;
            });
        },
        updateCartStore() {
          fetch(`${wpStoreData.rest_url}wpstore/v1/cart/get`, {
              headers: {
                'X-WP-Nonce': wpStoreData.nonce,
              }
            })
            .then(res => res.json())
            .then(data => {
              if (data.success) {
                Alpine.store('cart').total_qty = data.data.total_qty;
                Alpine.store('cart').total_price = data.data.total_price;
              }
            });
        }
      }
    }
  </script>
<?php
});
