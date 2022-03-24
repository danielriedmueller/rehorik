<?php
// TODO Remove after divi is removed
add_action('init' , 'remove_functions' , 15 );
function remove_functions() {
    remove_action( 'woocommerce_before_single_product_summary', 'et_divi_output_product_wrapper', 0  );
    remove_action( 'woocommerce_after_single_product_summary', 'et_divi_output_product_wrapper_end', 0  );
}


remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 10);
add_action( 'woocommerce_single_product_summary', 'cup_of_coffee', 15);
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 20);

add_action( 'woocommerce_after_single_product_summary', 'rehorik_bio_sigil', 5);
add_action( 'woocommerce_after_single_product_summary', 'rehorik_product_video', 5);
//add_action( 'woocommerce_after_single_product_summary', 'rehorik_single_product_attributes', 5);
//add_action( 'woocommerce_after_single_product_summary', 'rehorik_hugo_head', 5);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

add_action('woocommerce_after_single_product', 'woocommerce_output_related_products', 10);


function rehorik_single_product_attributes() {
    echo get_template_part('templates/product-single-attributes');
}

function rehorik_product_video() {
    global $product;
    get_template_part('templates/product-video', null, ['product' => $product]);
}

function rehorik_bio_sigil() {
    global $product;
    if(hasBiosigil($product)) {
        get_template_part('templates/bio-sigil', null, ['product' => $product]);
    }
}

function rehorik_hugo_head() {
    echo '<div class="rehorik-hugo-head"></div>';
}

function cup_of_coffee() {
    global $product;
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
}