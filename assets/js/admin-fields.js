document.addEventListener("DOMContentLoaded", function () {
  const skuInput = document.querySelector('input[name="sku"]');

  if (skuInput && skuInput.value === "") {
    const sitePrefix = wpStoreSku.sitePrefix || "WPS";
    const randomNumber = Math.floor(1000000 + Math.random() * 9000000);
    skuInput.value = sitePrefix + randomNumber;
  }

  // Format number inputs with class "harga-input"
  document.querySelectorAll(".harga-input").forEach(function (input) {
    input.addEventListener("input", function (e) {
      // Remove non-digit characters
      let val = e.target.value.replace(/[^0-9]/g, "");

      // Format with thousands separator
      if (val !== "") {
        val = parseInt(val, 10).toLocaleString("id-ID", {
          minimumFractionDigits: 0,
          maximumFractionDigits: 0,
        });
        e.target.value = val;
      } else {
        e.target.value = "";
      }
    });

    // Prevent non-number key presses
    input.addEventListener("keypress", function (e) {
      if (!/[0-9]/.test(e.key)) {
        e.preventDefault();
      }
    });
  });

  document.querySelectorAll(".stock-input").forEach(function (input) {
    input.addEventListener("input", function (e) {
      // Remove non-digit characters
      let val = e.target.value.replace(/[^0-9]/g, "");

      // Format with thousands separator
      if (val !== "") {
        val = parseInt(val, 10).toLocaleString("id-ID", {
          minimumFractionDigits: 0,
          maximumFractionDigits: 0,
        });
        e.target.value = val;
      } else {
        e.target.value = "";
      }
    });

    // Prevent non-number key presses
    input.addEventListener("keypress", function (e) {
      if (!/[0-9]/.test(e.key)) {
        e.preventDefault();
      }
    });
  });
});
