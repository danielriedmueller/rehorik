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

    if (isset($product_attributes['attribute_' . STRENGTH_ATTRIBUTE_SLUG])) {
        $product_attributes['attribute_' . STRENGTH_ATTRIBUTE_SLUG]['value'] = getStrengthFlavourHtml(
            $product_attributes['attribute_' . STRENGTH_ATTRIBUTE_SLUG]['value'],
            'strength');
    }

    if (isset($product_attributes['attribute_' . FLAVOUR_VARIETY_ATTRIBUTE_SLUG])) {
        $product_attributes['attribute_' . FLAVOUR_VARIETY_ATTRIBUTE_SLUG]['value'] = getStrengthFlavourHtml(
            $product_attributes['attribute_' . FLAVOUR_VARIETY_ATTRIBUTE_SLUG]['value'],
            'flavour'
        );
    }

    return $product_attributes;
}, 10, 2);