<?php
/**
 * Add categories to attributes
 * Remove weight and others
 */
add_filter( 'woocommerce_display_product_attributes', function ($productAttributes, $product) {
    $removeAttributesList = [
        ATTRIBUTE_SLUG_PREFIX.BIOSIGIL_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.PRODUCT_OF_MONTH_ATTRIBUTE_SLUG,
        WEIGHT_SLUG
    ];

    foreach ($removeAttributesList as $attribute) {
        unset($productAttributes[$attribute]);
    }

    if (isset($productAttributes[ATTRIBUTE_SLUG_PREFIX.STRENGTH_ATTRIBUTE_SLUG])) {
        $productAttributes[ATTRIBUTE_SLUG_PREFIX.STRENGTH_ATTRIBUTE_SLUG]['value'] = getStrengthFlavourHtml(
            $productAttributes[ATTRIBUTE_SLUG_PREFIX.STRENGTH_ATTRIBUTE_SLUG]['value'],
            'strength');
    }

    if (isset($productAttributes[ATTRIBUTE_SLUG_PREFIX.FLAVOUR_VARIETY_ATTRIBUTE_SLUG])) {
        $productAttributes[ATTRIBUTE_SLUG_PREFIX.FLAVOUR_VARIETY_ATTRIBUTE_SLUG]['value'] = getStrengthFlavourHtml(
            $productAttributes[ATTRIBUTE_SLUG_PREFIX.FLAVOUR_VARIETY_ATTRIBUTE_SLUG]['value'],
            'flavour'
        );
    }

    /**
     * If Bohnenkomposition is present, it becomes the label for Sorte
     */
    if (isset($productAttributes[ATTRIBUTE_SLUG_PREFIX.BEAN_COMPOSITION_ATTRIBUTE_SLUG])) {
        if ($productAttributes[ATTRIBUTE_SLUG_PREFIX.BEAN_COMPOSITION_ATTRIBUTE_SLUG]
            && $productAttributes[ATTRIBUTE_SLUG_PREFIX.VARIETIES_ATTRIBUTE_SLUG]) {
            $productAttributes[ATTRIBUTE_SLUG_PREFIX.VARIETIES_ATTRIBUTE_SLUG]['label']
                = $productAttributes[ATTRIBUTE_SLUG_PREFIX.BEAN_COMPOSITION_ATTRIBUTE_SLUG]['value'];
        }
    }

    return $productAttributes;
}, 10, 2);