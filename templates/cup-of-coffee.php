<?php
/** @var WC_Product $product */
$product = $args['product'];
$video = $product->get_meta('Video');

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
