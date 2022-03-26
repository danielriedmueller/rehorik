<?php
/**
 * Add categories to attributes
 * Remove weight and others
 */
add_filter( 'woocommerce_display_product_attributes', function ($product_attributes, $product) {
    $categories = getSubCategories($product);

    if (!empty($categories)) {
        $product_attributes['categories'] = [
            'label' => "Kategorie",
            'value' => $categories
        ];
    }

    // TODO merge atttributestempot
    unset($product_attributes['attribute_pa_product-of-month']);
    unset($product_attributes['weight']);

    return $product_attributes;
}, 10, 2);