document.addEventListener("DOMContentLoaded", function () {
  const skuInput = document.querySelector('input[name="sku"]');

  if (skuInput && skuInput.value === "") {
    // Generate SKU
    const sitePrefix = wpStoreSku.sitePrefix || "WPS"; // dari localized data
    const randomNumber = Math.floor(1000000 + Math.random() * 9000000);
    const sku = sitePrefix + randomNumber;

    skuInput.value = sku;
  }
});
