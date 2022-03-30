<?php

/**
 * Renders free shipping amount hint.
 */
add_action('render_free_shipping_amount', function () {
    $minAmount = getFreeShippingAmount();

    echo '<span>' . $minAmount . ' &euro;</span>';
});

/**
 * Renders rest amount for free shipping.
 */
add_action('render_rest_amount_for_free_shipping', function () {
    $restAmount = getAmountTillFreeShipping();
    $restAmount = str_replace('.', ',', $restAmount);

    if ($restAmount > 0) {
        echo 'Nur noch <span>' . $restAmount . ' &euro;</span> bis zum kostenlosen Versand!';
    }
});
