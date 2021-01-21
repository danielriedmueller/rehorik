<?php
/**
 * Remove product category count.
 */
add_filter('woocommerce_subcategory_count_html', '__return_false');

/**
 *  Define the woocommerce_get_product_terms callback
 *
 * @param $terms
 * @param $product_id
 * @param $taxonomy
 * @param $args
 * @return array
 */
function filter_woocommerce_get_product_terms( $terms, $product_id, $taxonomy, $args ) {
    if ($taxonomy === "product_cat") {
        return findShoptypeAwareProductSubcategory($terms);
    }

    return $terms;
};
add_filter('woocommerce_get_product_terms', 'filter_woocommerce_get_product_terms', 10, 4);