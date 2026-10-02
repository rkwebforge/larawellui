// The billing toggle: press one, and the price rolls to its amount.
document.addEventListener('click', (event) => {
    const button = event.target.closest('[data-billing]');
    const price = button && document.getElementById(button.getAttribute('aria-controls'));
    if (!price) {
        return;
    }
    button.parentElement.querySelectorAll('[data-billing]').forEach((other) => other.setAttribute('aria-pressed', String(other === button)));
    price.dataset.value = button.dataset.billing;
});
