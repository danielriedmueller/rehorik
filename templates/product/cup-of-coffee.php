<?php
/** @var WC_Product $product */
$product = $args['product'];

if (!isItCategory($product, COFFEE_CATEGORY_SLUG)) return;
if (!function_exists('wc_gzd_get_product')) return;

$woocommerceGzdProduct = wc_gzd_get_product($product);

$oneCupOfCoffeeInGrams = ONE_CUP_OF_COFFEE_IN_GRAMS;
$unitName = $woocommerceGzdProduct->get_unit();
$unitBase = $woocommerceGzdProduct->get_unit_base();
$unitAmount = $unitName === "kg"
    ? 1000
    : ($unitName === "g" ? 1 : null);

if ($unitAmount) {
    $multiplier = $oneCupOfCoffeeInGrams / $unitAmount;

    $unitPrice = empty($woocommerceGzdProduct->get_unit_price())
        ? $woocommerceGzdProduct->get_variation_unit_prices()
        : $woocommerceGzdProduct->get_unit_price();

    $formattedPriceRange = "";

    if (is_numeric($unitPrice)) {
        $priceForOneCup = $unitPrice * $multiplier * $unitBase;
        $formattedPriceRange = wc_price($priceForOneCup);
    }

    if (is_array($unitPrice) && array_key_exists('price', $unitPrice)) {
        $min = min(array_filter($unitPrice['price']));
        $max = max(array_filter($unitPrice['price']));

        $priceForOneCupMin =  number_format($min * $multiplier * $unitBase, 3);
        $priceForOneCupMax = number_format($max * $multiplier * $unitBase, 3);

        $formattedPriceRange = wc_format_price_range($priceForOneCupMin, $priceForOneCupMax);
    }

    if (!empty($formattedPriceRange)) {
        echo "<div class='rehorik-cup-of-coffee-price-outer'>Eine Tasse Kaffee kostet nur <span class='rehorik-cup-of-coffee-price'>${formattedPriceRange}</span> (${oneCupOfCoffeeInGrams} g)</div>";
    }
}
