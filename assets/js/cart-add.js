/**
 * WP Store - Add to Cart Functionality
 * Handles cart operations with variant support
 */

/**
 * Add to cart with variant support
 * @param {number} productId - Product ID
 * @param {object} variants - Selected variants
 * @param {number} quantity - Quantity to add
 * @param {string} restUrl - REST API URL
 * @param {string} nonce - Security nonce
 */
function addToCartWithVariant(
  productId,
  variants = {},
  quantity = 1,
  restUrl = "",
  nonce = ""
) {
  return {
    // State
    loading: false,
    message: "",
    messageType: "",
    selectedVariants: variants,
    selectedQuantity: quantity,

    // Initialize
    init() {
      // Set initial state
      this.selectedVariants = variants || {};
      this.selectedQuantity = quantity || 1;
    },

    // Update variant selection
    updateVariant(key, value) {
      this.selectedVariants[key] = value;
      this.clearMessage();
    },

    // Update quantity
    updateQuantity(newQuantity) {
      const qty = parseInt(newQuantity);
      if (qty > 0) {
        this.selectedQuantity = qty;
        this.clearMessage();
      }
    },

    // Add to cart
    async addToCart() {
      if (this.loading) return;

      try {
        this.loading = true;
        this.clearMessage();

        // Validate required variants
        const hasRequiredVariants = this.validateVariants();
        if (!hasRequiredVariants) {
          this.showMessage("Please select all required options", "error");
          return;
        }

        // Prepare data
        const cartData = {
          product_id: productId,
          quantity: this.selectedQuantity,
          variants: this.selectedVariants,
        };

        // Make API request
        const response = await fetch(`${restUrl}wp-store/v1/cart/add`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-WP-Nonce": nonce,
          },
          body: JSON.stringify(cartData),
        });

        const result = await response.json();

        if (response.ok && result.success) {
          this.showMessage(
            result.message || "Product added to cart successfully!",
            "success"
          );

          // Update cart badge if exists
          this.updateCartBadge(result.cart_count);

          // Trigger custom event
          this.dispatchCartEvent("cart-updated", {
            product_id: productId,
            quantity: this.selectedQuantity,
            variants: this.selectedVariants,
            cart_count: result.cart_count,
          });
        } else {
          this.showMessage(
            result.message || "Failed to add product to cart",
            "error"
          );
        }
      } catch (error) {
        console.error("Add to cart error:", error);
        this.showMessage("An error occurred. Please try again.", "error");
      } finally {
        this.loading = false;
      }
    },

    // Validate required variants
    validateVariants() {
      // Basic validation - can be extended based on requirements
      return true;
    },

    // Show message
    showMessage(text, type = "info") {
      this.message = text;
      this.messageType = type;

      // Auto-hide success messages
      if (type === "success") {
        setTimeout(() => {
          this.clearMessage();
        }, 3000);
      }
    },

    // Clear message
    clearMessage() {
      this.message = "";
      this.messageType = "";
    },

    // Update cart badge
    updateCartBadge(count) {
      const badges = document.querySelectorAll(
        ".cart-badge, [data-cart-badge]"
      );
      badges.forEach((badge) => {
        badge.textContent = count || "0";
        badge.style.display = count > 0 ? "inline" : "none";
      });
    },

    // Dispatch custom event
    dispatchCartEvent(eventName, detail) {
      const event = new CustomEvent(eventName, {
        detail: detail,
        bubbles: true,
        cancelable: true,
      });
      document.dispatchEvent(event);
    },

    // Get message CSS classes
    getMessageClasses() {
      const baseClasses = "alert";
      switch (this.messageType) {
        case "success":
          return `${baseClasses} alert-success`;
        case "error":
          return `${baseClasses} alert-danger`;
        case "warning":
          return `${baseClasses} alert-warning`;
        default:
          return `${baseClasses} alert-info`;
      }
    },
  };
}

/**
 * Simple add to cart function (without variants)
 * @param {number} productId - Product ID
 * @param {number} quantity - Quantity to add
 * @param {string} restUrl - REST API URL
 * @param {string} nonce - Security nonce
 */
function addToCart(productId, quantity = 1, restUrl = "", nonce = "") {
  return addToCartWithVariant(productId, {}, quantity, restUrl, nonce);
}

/**
 * Cart badge component
 */
function cartBadge() {
  return {
    count: 0,

    init() {
      this.loadCartCount();

      // Listen for cart updates
      document.addEventListener("cart-updated", (event) => {
        this.count = event.detail.cart_count || 0;
      });
    },

    async loadCartCount() {
      try {
        const response = await fetch(`${wpStore.restUrl}wp-store/v1/cart/get`, {
          headers: {
            "X-WP-Nonce": wpStore.nonce,
          },
        });

        if (response.ok) {
          const result = await response.json();
          this.count = result.cart_count || 0;
        }
      } catch (error) {
        console.error("Failed to load cart count:", error);
      }
    },
  };
}

// Make functions globally available
window.addToCartWithVariant = addToCartWithVariant;
window.addToCart = addToCart;
window.cartBadge = cartBadge;

// Auto-initialize cart badges
document.addEventListener("DOMContentLoaded", function () {
  // Initialize cart badges that don't use Alpine.js
  const staticBadges = document.querySelectorAll(".cart-badge:not([x-data])");
  staticBadges.forEach((badge) => {
    const cartBadgeInstance = cartBadge();
    cartBadgeInstance.init();
  });
});
