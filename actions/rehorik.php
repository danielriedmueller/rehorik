<?php

/**
 * Renders coffee beans and flowers on coffee detail page.
 */
add_action('render_product_attribute_strength_flavour', function ($level, $class) {
    $level = strip_tags($level);

    echo '<div class="rehorik-product-strength-flavour-container">';
    for ($i = 1; $i <= MAX_COFFEE_STRENGTH_FLAVOUR_ATTRIBUTE; $i++) {
        if ($i <= (int)$level) {
            echo "<span class='rehorik-coffee-${class}-${i}-filled'></span>";
        } else {
            echo "<span class='rehorik-coffee-${class}-${i}'></span>";
        }
    }
    echo '</div>';
}, 10, 2);

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
