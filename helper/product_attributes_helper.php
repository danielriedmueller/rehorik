<?php

function extractStrengthAndFlavourAttributes(array $productAttributes): array
{
    return [
        'strength' => $productAttributes[STRENGTH_ATTRIBUTE_SLUG],
        'flavour' => $productAttributes[FLAVOUR_VARIETY_ATTRIBUTE_SLUG]
    ];
}

function extractOtherAttributes(array $productAttributes): array
{
    unset($productAttributes[STRENGTH_ATTRIBUTE_SLUG]);
    unset($productAttributes[FLAVOUR_VARIETY_ATTRIBUTE_SLUG]);

    if ($productAttributes[BEAN_COMPOSITION_ATTRIBUTE_SLUG]
        && $productAttributes[COFFEE_TYPE_ATTRIBUTE_SLUG]) {
        $productAttributes[COFFEE_TYPE_ATTRIBUTE_SLUG]['label'] = $productAttributes[BEAN_COMPOSITION_ATTRIBUTE_SLUG]['value'];
        unset($productAttributes[BEAN_COMPOSITION_ATTRIBUTE_SLUG]);
    }

    return $productAttributes;
}

function isProductOfTheMonth(WC_Product_Variable $product): bool
{
    $value = strtolower($product->get_attribute( PRODUCT_OF_MONTH_ATTRIBUTE_SLUG));

    return $value === "ja" ? true : false;
}

function hasBiosigil(WC_Product_Variable $product): bool
{
    $value = strtolower($product->get_attribute( BIOSIGIL_SLUG));

    return $value === "ja" ? true : false;
}

function getProductOfTheMonthClass(WC_Product_Variable $product): string
{
    return isProductOfTheMonth($product) ? "product-of-month" : "";
}

function getBiosigilClass(WC_Product_Variable $product): string
{
    return hasBiosigil($product) ? "biosigil" : "";
}

function getOriginCountry(WC_Product_Variable $product): string
{
    $attributeArr = getAttributeArray($product, ORIGIN_COUNTRY_ATTRIBUTE_SLUG);

    if (sizeof($attributeArr) > MAX_DISPLAY_ORIGIN_COUNTRIES) {
        return "Blend";
    }

    return implode(", ", $attributeArr);
}

/**
 * Returns a single product attribute as array.
 */
function getAttributeArray(WC_Product_Variable $product, string $attribute): array
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