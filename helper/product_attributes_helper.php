<?php
require_once('product_sigil_helper.php');

function getOriginCountry(WC_Product $product): string
{
    $region = $product->get_attribute(REGION_ATTRIBUTE_SLUG);

    $attributeArr = getAttributeArray($product, ORIGIN_COUNTRY_ATTRIBUTE_SLUG);
    if (sizeof($attributeArr) > MAX_DISPLAY_ORIGIN_COUNTRIES) {
        $country = "Blend";
    } else {
        $country = implode(", ", $attributeArr);
    }

    return implode (" - ", array_filter([$country, $region], function ($a) {
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
    $maxStrengthValue = 6;

    $result = '<div class="rehorik-product-strength-flavour-container">';
    for ($i = 1; $i <= $maxStrengthValue; $i++) {
        if ($i <= (int)$level) {
            $result .= "<span class='rehorik-coffee-${class}-${i}-filled'></span>";
        } else {
            $result .= "<span class='rehorik-coffee-${class}-${i}'></span>";
        }
    }
    $result .= '</div>';

    return $result;
}

/**
 * If product is not selling, remove add to cart button and show message.
 */
function isProductSelling(WC_Product $product) {
    if (isItCategory($product, MACHINE_CATEGORY_SLUG)) {
        return false;
    }

    return true;
}
