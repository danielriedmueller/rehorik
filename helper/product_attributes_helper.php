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
    $value = $product->get_attribute( PRODUCT_OF_MONTH_ATTRIBUTE_SLUG);

    return $value === "Ja" ? true : false;
}

function getProductOfTheMonthClass(WC_Product_Variable $product): string
{
    return isProductOfTheMonth($product) ? "product-of-month" : "";
}