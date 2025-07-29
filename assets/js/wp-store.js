/**
 * WP Store - Main JavaScript File
 * Core functionality and Alpine.js components
 */

// Global WP Store object
window.wpStore = {
  nonce: wpStoreData?.nonce || "",
  restUrl: wpStoreData?.rest_url || "/wp-json/",

  // Utility functions
  formatPrice(price, currency = "Rp") {
    const numPrice = parseFloat(price) || 0;
    return currency + " " + new Intl.NumberFormat("id-ID").format(numPrice);
  },

  // Show notification
  showNotification(message, type = "info") {
    // Simple notification system
    const notification = document.createElement("div");
    notification.className = `alert alert-${type} position-fixed`;
    notification.style.cssText =
      "top: 20px; right: 20px; z-index: 9999; min-width: 300px;";
    notification.innerHTML = `
      <div class="d-flex justify-content-between align-items-center">
        <span>${message}</span>
        <button type="button" class="btn-close" onclick="this.parentElement.parentElement.remove()"></button>
      </div>
    `;
    document.body.appendChild(notification);

    // Auto remove after 5 seconds
    setTimeout(() => {
      if (notification.parentNode) {
        notification.remove();
      }
    }, 5000);
  },
};

// Initialize when DOM is ready
document.addEventListener("DOMContentLoaded", function () {
  console.log("WP Store initialized");

  // Setup global Alpine.js data if needed
  if (typeof Alpine !== "undefined") {
    Alpine.start();
  }
});
