document.addEventListener('DOMContentLoaded', () => {
    const status = document.getElementById('status');
    const updateSkuButton = document.getElementById('update-sku-button');
    const updateCoffeePrice = document.getElementById('update-coffee-price-button');

    if (updateSkuButton) {
        updateSkuButton.onclick = () => {
            status.innerHTML = 'Pending...';
            jQuery.post(ajaxurl, {
                'action': 'update_sku',
            }, function(response) {
                status.innerHTML = response;
            });
        }
    }

    if (updateCoffeePrice) {
        updateCoffeePrice.onclick = () => {
            status.innerHTML = 'Pending...';
            jQuery.post(ajaxurl, {
                'action': 'update_coffee_price',
            }, function(response) {
                status.innerHTML = response;
            });
        }
    }
});