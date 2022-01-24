<?php
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

function isProductOfTheMonth(WC_Product $product): bool
{
    $value = strtolower($product->get_attribute( PRODUCT_OF_MONTH_ATTRIBUTE_SLUG));

    return $value === "ja" ? true : false;
}

function hasBiosigil(WC_Product $product): bool
{
    $value = validateBiosigilControlcode($product->get_attribute(BIOSIGIL_ATTRIBUTE_SLUG));

    return !empty($value);
}

function isEventOnline($eventId): bool
{
    if (!function_exists('tribe_events_get_ticket_event')) return false;

    $categories = tribe_get_event_cat_slugs($eventId);
    if (in_array(VIRTUAL_EVENTS_CATEGORY_SLUG, $categories)) {
        return true;
    }

    $isOnline = get_post_meta($eventId, ONLINE_META_KEY);

    return !!$isOnline;
}

function getProductOfTheMonthClass(WC_Product $product): string
{
    return isProductOfTheMonth($product) ? "product-of-month" : "";
}

function getBiosigilClass(WC_Product $product): string
{
    return hasBiosigil($product) ? "biosigil" : "";
}

function getBiosigilControlcode(WC_Product $product): string
{
    $value = validateBiosigilControlcode($product->get_attribute(BIOSIGIL_ATTRIBUTE_SLUG));

    return !empty($value) ? $value : "";
}

/**
 * Validates BioSigil-EU-Controlcode.
 *
 * If $value is three digits reference number, complete controlcode will be returned.
 * If invalid, empty string will be returned.
 *
 * @param string $value
 * @param string $defaultIsoPart
 * @return string
 */
function validateBiosigilControlcode(
    string $value,
    string $defaultIsoPart = "DE-ÖKO-"
): string {
    if (empty($value)) {
        return "";
    }

    $referenceNumberLength = 3;
    $isoPartLength = mb_strlen($defaultIsoPart);

    if (is_numeric($value)) {
        if (mb_strlen($value) !== $referenceNumberLength) {
            return "";
        }

        $value = $defaultIsoPart . $value;
    }

    if (mb_strlen($value) !== $isoPartLength + $referenceNumberLength) {
        return "";
    }

    if (mb_substr($value, 2, 1) !== "-" || mb_substr($value, 6, 1) !== "-") {
        return "";
    }

    if (!is_numeric(mb_substr($value, 7, 3))) {
        return "";
    }

    return strtoupper($value);
}

function getIsEventOnlineClass(WC_Product $product): string
{
    $event = tribe_events_get_ticket_event($product->get_id());

    if(!$event) {
        return "";
    }

    return isEventOnline($event->ID) ? "event-online" : "";
}

function getOriginCountry(WC_Product $product): string
{
    $category = getSubCategory($product);
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