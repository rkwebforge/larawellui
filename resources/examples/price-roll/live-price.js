// In a real app the new price comes from your server (polling, a websocket); setting data-value is all it takes.
document.addEventListener('click', (event) => {
    const button = event.target.closest('[data-price-change]');
    const price = button && document.getElementById(button.getAttribute('aria-controls'));
    if (price) {
        price.dataset.value = Math.max(0, Number(price.dataset.value) + Number(button.dataset.priceChange)).toFixed(2);
    }
});
