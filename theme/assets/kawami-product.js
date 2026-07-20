// Kawami — minimal variant picker: matches selected options to a variant,
// updates the hidden variant id, price, availability, and preorder/stock badge.
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-kawami-product-form]').forEach((form) => {
    const variants = JSON.parse(form.querySelector('[data-variants-json]').textContent);
    const idInput = form.querySelector('[name="id"]');
    const priceEl = form.querySelector('[data-price]');
    const compareEl = form.querySelector('[data-compare-price]');
    const addBtn = form.querySelector('[data-add-button]');
    const availabilityEl = form.querySelector('[data-availability]');
    const selects = Array.from(form.querySelectorAll('[data-option-select]'));

    function currentOptions() {
      return selects.map((s) => s.value);
    }

    function findVariant() {
      const opts = currentOptions();
      return variants.find((v) => v.options.every((o, i) => o === opts[i]));
    }

    function money(cents) {
      return (cents / 100).toFixed(2).replace('.', ',') + ' €';
    }

    function update() {
      const variant = findVariant();
      if (!variant) return;
      idInput.value = variant.id;
      if (priceEl) priceEl.textContent = money(variant.price);
      if (compareEl) {
        if (variant.compare_at_price && variant.compare_at_price > variant.price) {
          compareEl.textContent = money(variant.compare_at_price);
          compareEl.style.display = '';
        } else {
          compareEl.style.display = 'none';
        }
      }
      if (addBtn) {
        addBtn.disabled = !variant.available;
        addBtn.textContent = variant.available ? addBtn.dataset.addText : addBtn.dataset.soldOutText;
      }
      if (availabilityEl) {
        availabilityEl.textContent = variant.available ? availabilityEl.dataset.inStockText : availabilityEl.dataset.soldOutText;
      }
    }

    selects.forEach((s) => s.addEventListener('change', update));
    update();
  });
});
