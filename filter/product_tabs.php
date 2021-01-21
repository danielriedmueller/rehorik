<?php
/**
 * Rename product data tabs
 */
function woo_rename_tabs( $tabs ) {

    $tabs['description']['title'] = 'Beschreibung';
    $tabs['additional_information']['title'] = 'Information';

    $tabs['description']['priority'] = 20;
    $tabs['additional_information']['priority'] = 15;

    return $tabs;
}
add_filter('woocommerce_product_tabs', 'woo_rename_tabs', 98);

add_filter('wc_product_enable_dimensions_display', '__return_false');

/**
 * Removes empty tabs in product detail view
 *
 * @param $woocommerce_default_product_tabs
 * @return mixed
 */
function filter_woocommerce_product_tabs( $woocommerce_default_product_tabs ) {
    global $product;

    if (empty($product->get_description())) {
        unset($woocommerce_default_product_tabs['description']);
    }

    $attributes = array_filter($product->get_attributes(), function ($attribute) {
        return in_array($attribute, INFORMATION_TAB_ATTRIBUTES);
    }, ARRAY_FILTER_USE_KEY);
    if (empty($attributes)) {
        unset($woocommerce_default_product_tabs['additional_information']);
    }

    return $woocommerce_default_product_tabs;
};
add_filter('woocommerce_product_tabs', 'filter_woocommerce_product_tabs', 98);