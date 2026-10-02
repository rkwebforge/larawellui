// Raises each listed price by 5%, to show how each colour mode treats the same move.
document.addEventListener('click', (event) => {
    const button = event.target.closest('[data-raise-all]');
    if (!button) {
        return;
    }
    for (const id of button.dataset.raiseAll.split(' ')) {
        const price = document.getElementById(id);
        price.dataset.value = (Number(price.dataset.value) * 1.05).toFixed(2);
    }
});
