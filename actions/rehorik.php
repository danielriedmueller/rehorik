<?php
/**
 * Adds price for one coup of coffee.
 */
add_action('render_one_cup_of_coffee_price', function ($product) {
    if (!isItCategory($product, COFFEE_CATEGORY_SLUG)) return;

    $woocommerceGzProduct = wc_gzd_get_product($product);

    $oneCupOfCoffeeInGrams = ONE_CUP_OF_COFFEE_IN_GRAMS;
    $unitName = $woocommerceGzProduct->get_unit();
    $unitBase = $woocommerceGzProduct->get_unit_base();
    $unitAmount = $unitName === "kg"
        ? 1000
        : ($unitName === "g" ? 1 : null);

    if ($unitAmount) {
        $multiplier = $oneCupOfCoffeeInGrams / $unitAmount;

        $unitPrice = empty($woocommerceGzProduct->get_unit_price())
            ? $woocommerceGzProduct->get_variation_unit_prices()
            : $woocommerceGzProduct->get_unit_price();

        $formattedPriceRange = "";

        if (is_numeric($unitPrice)) {
            $priceForOneCup = $unitPrice * $multiplier * $unitBase;
            $formattedPriceRange = wc_price($priceForOneCup);
        }

        if (is_array($unitPrice) && array_key_exists('price', $unitPrice)) {
            $min = min(array_filter($unitPrice['price']));
            $max = max(array_filter($unitPrice['price']));

            $priceForOneCupMin =  number_format($min * $multiplier * $unitBase, 2);
            $priceForOneCupMax = number_format($max * $multiplier * $unitBase, 2);

            $formattedPriceRange = wc_format_price_range($priceForOneCupMin, $priceForOneCupMax);
        }

        if (!empty($formattedPriceRange)) {
            echo "<div class='rehorik-cup-of-coffee-price-outer'>Eine Tasse Kaffee kostet nur <span class='rehorik-cup-of-coffee-price'>${formattedPriceRange}</span> (${oneCupOfCoffeeInGrams} g)</div>";
        }
    }
});

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
