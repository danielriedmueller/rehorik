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
        ATTRIBUTE_SLUG_PREFIX.BIODYNAMIC_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.VEGAN_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.REGIONAL_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.WINERY_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.GOES_WITH_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.QUALITY_NAME_ATTRIBUTE_SLUG,
        WEIGHT_SLUG
    ];

    foreach ($removeAttributesList as $attribute) {
        unset($productAttributes[$attribute]);
    }

    /**
     * If Bio, add "BIO" beforehand Sorte value
     */
    if ($productAttributes[ATTRIBUTE_SLUG_PREFIX.VARIETIES_ATTRIBUTE_SLUG]
        && !empty(generateBioSigilControlcode($product->get_attribute(BIOSIGIL_ATTRIBUTE_SLUG)))
    ) {
        $value = $productAttributes[ATTRIBUTE_SLUG_PREFIX.VARIETIES_ATTRIBUTE_SLUG]["value"];
        $productAttributes[ATTRIBUTE_SLUG_PREFIX.VARIETIES_ATTRIBUTE_SLUG]["value"] = str_replace('"tag">', '"tag">BIO ', $value);
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
     * If Bohnenkomposition (Mischung) is present, it becomes the label for Sorte
     */
    if (isset($productAttributes[ATTRIBUTE_SLUG_PREFIX.BEAN_COMPOSITION_ATTRIBUTE_SLUG])) {
        if ($productAttributes[ATTRIBUTE_SLUG_PREFIX.BEAN_COMPOSITION_ATTRIBUTE_SLUG]
            && $productAttributes[ATTRIBUTE_SLUG_PREFIX.VARIETIES_ATTRIBUTE_SLUG]) {
            $productAttributes[ATTRIBUTE_SLUG_PREFIX.VARIETIES_ATTRIBUTE_SLUG]['label']
                = $productAttributes[ATTRIBUTE_SLUG_PREFIX.BEAN_COMPOSITION_ATTRIBUTE_SLUG]['value'];
        }
    }

    if (isset($productAttributes[ATTRIBUTE_SLUG_PREFIX.REGION_ATTRIBUTE_SLUG])) {
        if ($productAttributes[ATTRIBUTE_SLUG_PREFIX.REGION_ATTRIBUTE_SLUG]
            && $productAttributes[ATTRIBUTE_SLUG_PREFIX.ORIGIN_COUNTRY_ATTRIBUTE_SLUG]) {
            $productAttributes[ATTRIBUTE_SLUG_PREFIX.REGION_ATTRIBUTE_SLUG]['value'] =
                trim(strip_tags($productAttributes[ATTRIBUTE_SLUG_PREFIX.ORIGIN_COUNTRY_ATTRIBUTE_SLUG]['value']))
                . ", " . trim(strip_tags($productAttributes[ATTRIBUTE_SLUG_PREFIX.REGION_ATTRIBUTE_SLUG]['value']));
            unset($productAttributes[ATTRIBUTE_SLUG_PREFIX.ORIGIN_COUNTRY_ATTRIBUTE_SLUG]);
        }
    }

    /**
     * Sort attributes
     *
     *  1. Jahrgang
     *  2. Rebsorte
     *  3. Weingut
     *  5. Region
     *  6. Geschmack (formerly known as Ausbau)
     *  7. Aromen
     *  8. Alkohol
     */
    $sortedAttributes = [
        ATTRIBUTE_SLUG_PREFIX.VINTAGE_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.GRAPE_VARIETY_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.WINERY_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.REGION_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.AUSBAU_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.FLAVOUR_ATTRIBUTE_SLUG,
        ATTRIBUTE_SLUG_PREFIX.ALCOHOL_ATTRIBUTE_SLUG,
        WEIGHT_SLUG
    ];
    uksort($productAttributes, function ($a, $b) use ($sortedAttributes) {
        if (array_search($a, $sortedAttributes) > array_search($b, $sortedAttributes)) {
            return 1;
        }

        return -1;
    });

    return $productAttributes;
}, 10, 2);