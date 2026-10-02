// A new price from your server is all it takes: set data-value, and the digits and the badge follow.
document.addEventListener('click', (event) => {
    const button = event.target.closest('[data-price-step]');
    const price = button && document.getElementById(button.getAttribute('aria-controls'));
    if (price) {
        price.dataset.value = Math.max(0, Number(price.dataset.value) + Number(button.dataset.priceStep)).toFixed(2);
    }
});
