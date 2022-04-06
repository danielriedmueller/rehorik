<?php
/**
 * Add categories to attributes
 * Remove weight and others
 */
add_filter('woocommerce_display_product_attributes', function ($productAttributes, $product) {
    $removeAttributesList = [
        ATTRIBUTE_SLUG_PREFIX.BIOSIGIL_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.PRODUCT_OF_MONTH_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.FILLING_QUANTITY_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.WEIGHT_ATTRIBUTE_SLUG,
        WEIGHT_SLUG
    ];

    foreach ($removeAttributesList as $attribute) {
        unset($productAttributes[$attribute]);
    }

    /**
     * Add Fuellmenge if single product
     */
    if (!$product->is_type('variable')) {
        $productAttributes[WEIGHT_SLUG] = array(
            'label' => wc_gzd_get_product( $product )->get_unit() === "l" ? "Füllmenge" : "Gewicht",
            'value' => wc_gzd_get_product( $product )->get_unit_product_html()
        );
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

    /**
     * Sort attributes
     *
     *  1. Jahrgang
     *  2. Rebsorte
     *  3. Weingut
     *  4. Herkunft
     *  5. Region
     *  6. Geschmack (formerly known as Ausbau)
     *  7. Aromen
     *  8. Alkohol
     */
    $sortedAttributes = [
        ATTRIBUTE_SLUG_PREFIX.VINTAGE_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.GRAPE_VARIETY_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.WINERY_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.ORIGIN_COUNTRY_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.REGION_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.AUSBAU_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.FLAVOUR_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.ALCOHOL_ATTRIBUTE_SLUG
    ];
    uksort($productAttributes, function ($a, $b) use ($sortedAttributes) {
        if (array_search($a, $sortedAttributes) > array_search($b, $sortedAttributes)) {
            return 1;
        }

        return -1;
    });

    return $productAttributes;
}, 10, 2);