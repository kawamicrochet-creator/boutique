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

    // Mirrors snippets/kawami-availability-badge.liquid: a variant Shopify still
    // lets customers buy despite zero tracked inventory is "continue selling
    // when out of stock" - i.e. made-to-order / précommande, not truly sold out.
    function badgeState(variant) {
      if (!variant.available) return 'soldout';
      if (variant.inventory_management && variant.inventory_quantity <= 0) return 'preorder';
      return 'instock';
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
        const state = badgeState(variant);
        availabilityEl.classList.remove('k-badge-instock', 'k-badge-preorder');
        availabilityEl.style.background = '';
        availabilityEl.style.color = '';
        if (state === 'instock') {
          availabilityEl.classList.add('k-badge-instock');
          availabilityEl.textContent = 'En stock';
        } else if (state === 'preorder') {
          availabilityEl.classList.add('k-badge-preorder');
          availabilityEl.textContent = availabilityEl.dataset.preorderText || 'Précommande';
        } else {
          availabilityEl.style.background = 'var(--k-border)';
          availabilityEl.style.color = 'var(--k-text)';
          availabilityEl.textContent = 'Épuisé';
        }
      }
    }

    selects.forEach((s) => s.addEventListener('change', update));
    update();
  });
});
