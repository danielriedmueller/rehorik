<?php

require_once('product_sigil_helper.php');

/**
 * Returns only Herkunft, Sorte, Aromen, Fett
 * If Bohnenkomposition is present, it becomes the label for Sorte
 * If Rebsorte is present, add id to Sorte
 * If Herkunft und Region is present, add Region to Herkunft
 *
 * @param array $productAttributes
 * @return array
 */
function extractOtherAttributes(array $productAttributes): array
{
    if (isset($productAttributes[ATTRIBUTE_SLUG_PREFIX.BEAN_COMPOSITION_ATTRIBUTE_SLUG])) {
        if ($productAttributes[ATTRIBUTE_SLUG_PREFIX.BEAN_COMPOSITION_ATTRIBUTE_SLUG]
            && $productAttributes[ATTRIBUTE_SLUG_PREFIX.VARIETIES_ATTRIBUTE_SLUG]) {
            $productAttributes[ATTRIBUTE_SLUG_PREFIX.VARIETIES_ATTRIBUTE_SLUG]['label']
                = $productAttributes[ATTRIBUTE_SLUG_PREFIX.BEAN_COMPOSITION_ATTRIBUTE_SLUG]['value'];
        }
    }

    if (isset($productAttributes[ATTRIBUTE_SLUG_PREFIX.GRAPE_VARIETY_ATTRIBUTE_SLUG])) {
        if ($productAttributes[ATTRIBUTE_SLUG_PREFIX.GRAPE_VARIETY_ATTRIBUTE_SLUG]
            && $productAttributes[ATTRIBUTE_SLUG_PREFIX.VARIETIES_ATTRIBUTE_SLUG]) {
            $productAttributes[ATTRIBUTE_SLUG_PREFIX.VARIETIES_ATTRIBUTE_SLUG]['value'] =
            $productAttributes[ATTRIBUTE_SLUG_PREFIX.VARIETIES_ATTRIBUTE_SLUG]['value']
            . $productAttributes[ATTRIBUTE_SLUG_PREFIX.GRAPE_VARIETY_ATTRIBUTE_SLUG]['value'];
        }
    }

    if (isset($productAttributes[ATTRIBUTE_SLUG_PREFIX.REGION_ATTRIBUTE_SLUG])) {
        if ($productAttributes[ATTRIBUTE_SLUG_PREFIX.REGION_ATTRIBUTE_SLUG]
            && $productAttributes[ATTRIBUTE_SLUG_PREFIX.ORIGIN_COUNTRY_ATTRIBUTE_SLUG]) {
            $productAttributes[ATTRIBUTE_SLUG_PREFIX.ORIGIN_COUNTRY_ATTRIBUTE_SLUG]['value'] =
                $productAttributes[ATTRIBUTE_SLUG_PREFIX.ORIGIN_COUNTRY_ATTRIBUTE_SLUG]['value']
                . $productAttributes[ATTRIBUTE_SLUG_PREFIX.REGION_ATTRIBUTE_SLUG]['value'];
        }
    }

    return array_values(array_filter($productAttributes, function ($key) {
        return in_array(str_replace(ATTRIBUTE_SLUG_PREFIX, "", $key), INFORMATION_TAB_ATTRIBUTES);
    }, ARRAY_FILTER_USE_KEY));
}

function getOriginCountry(WC_Product $product): string
{
    $category = getSubCategories($product);
    $region = $product->get_attribute(REGION_ATTRIBUTE_SLUG);

    $attributeArr = getAttributeArray($product, ORIGIN_COUNTRY_ATTRIBUTE_SLUG);
    if (sizeof($attributeArr) > MAX_DISPLAY_ORIGIN_COUNTRIES) {
        $country = "Blend";
    } else {
        $country = implode(", ", $attributeArr);
    }

    return implode (" - ", array_filter([$category, $country, $region], function ($a) {
        return !!$a;
    }));
}

/**
 * Returns a single product attribute as array.
 */
function getAttributeArray(WC_Product $product, string $attribute): array
{
    $attributes = $product->get_attributes();
    $attribute  = sanitize_title( $attribute );

    if ( isset( $attributes[$attribute] ) ) {
        $attribute_object = $attributes[$attribute];
    } elseif ( isset( $attributes['pa_' . $attribute] ) ) {
        $attribute_object = $attributes['pa_' . $attribute];
    } else {
        return [];
    }

    return $attribute_object->is_taxonomy()
        ? wc_get_product_terms( $product->get_id(), $attribute_object->get_name(), array( 'fields' => 'names' ) )
        : $attribute_object->get_options();
}

/**
 * Creates coffee beans and flowers on coffee detail page.
 */
function getStrengthFlavourHtml($level, $class) {
    $level = strip_tags($level);

    $result = '<div class="rehorik-product-strength-flavour-container">';
    for ($i = 1; $i <= MAX_COFFEE_STRENGTH_FLAVOUR_ATTRIBUTE; $i++) {
        if ($i <= (int)$level) {
            $result .= "<span class='rehorik-coffee-${class}-${i}-filled'></span>";
        } else {
            $result .= "<span class='rehorik-coffee-${class}-${i}'></span>";
        }
    }
    $result .= '</div>';

    return $result;
}