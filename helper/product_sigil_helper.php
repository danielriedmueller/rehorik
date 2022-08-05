<?php

function isProductOfTheMonth(WC_Product $product): bool {
    return str_contains($product->get_attribute(GUETESIEGEL_ATTRIBUTE_SLUG), 'Produkt des Monats');
}

function hasBioSigil(WC_Product $product): bool {
    $value = generateBioSigilControlcode($product->get_attribute(BIOSIGIL_ATTRIBUTE_SLUG));

    return !empty($value) && str_contains($product->get_attribute(GUETESIEGEL_ATTRIBUTE_SLUG), 'Biosiegel');
}

function hasVeganSigil(WC_Product $product): bool {
    return str_contains($product->get_attribute(GUETESIEGEL_ATTRIBUTE_SLUG), 'Vegan');
}

function hasBiodynamicSigil(WC_Product $product): bool {
    return str_contains($product->get_attribute(GUETESIEGEL_ATTRIBUTE_SLUG), 'Biodynamisch');
}

function hasRegionalSigil(WC_Product $product): bool {
    return str_contains($product->get_attribute(GUETESIEGEL_ATTRIBUTE_SLUG), 'Regional');
}

function hasCottonSigil(WC_Product $product): bool {
    return str_contains($product->get_attribute(GUETESIEGEL_ATTRIBUTE_SLUG), '100% Baumwolle');
}

function isEventOnline($eventId): bool {
    if (!function_exists('tribe_events_get_ticket_event')) {
        return false;
    }

    $categories = tribe_get_event_cat_slugs($eventId);
    if (!empty(array_intersect(VIRTUAL_EVENTS_CATEGORY_SLUGS, $categories))) {
        return true;
    }

    $isOnline = get_post_meta($eventId, ONLINE_META_KEY);

    return !!$isOnline;
}

function getProductOfTheMonthClass(WC_Product $product): string {
    if (isProductOfTheMonth($product)) {
        if (isItCategory($product, WINE_CATEGORY_SLUG)) {
           return "product-of-month wine-of-month";
        }

        return "product-of-month";
    }

    return "";
}

function getIsEventOnlineClass(WC_Product $product): string {
    $event = tribe_events_get_ticket_event($product->get_id());

    if (!$event) {
        return "";
    }

    return isEventOnline($event->ID) ? "event-online" : "";
}

function getBioSigilClass(WC_Product $product): string {
    return hasBioSigil($product) ? "biosigil" : "";
}

function getVeganSigilClass(WC_Product $product): string {
    return hasVeganSigil($product) ? "vegansigil" : "";
}

function getBiodynamicSigilClass(WC_Product $product): string {
    return hasBiodynamicSigil($product) ? "biodynamicsigil" : "";
}

function getRegionalSigilClass(WC_Product $product): string {
    return hasRegionalSigil($product) ? "regionalsigil" : "";
}

function getCottonSigilClass(WC_Product $product): string {
    return hasCottonSigil($product) ? "cottonsigil" : "";
}

function getBioSigilControlcode(WC_Product $product): string {
    $value = generateBioSigilControlcode($product->get_attribute(BIOSIGIL_ATTRIBUTE_SLUG));

    return !empty($value) ? $value : "";
}

/**
 * Generates BioSigil-EU-Controlcode.
 *
 * If $value is three digits reference number, complete controlcode will be returned.
 * If invalid, empty string will be returned.
 *
 * @param string $value
 * @param string $defaultIsoPart
 * @return string
 */
function generateBioSigilControlcode(
    string $value,
    string $defaultIsoPart = "DE-ÖKO-"
): string {
    // Append default iso part if given value is reference number>
    if (is_numeric($value)) {
        $value = $defaultIsoPart . $value;
    }

    return validateBioSigilControlcode($value) ? strtoupper($value) : "";
}

/**
 * Validates BioSigil-EU-Controlcode.
 *
 * @param string $value
 * @return bool
 */
function validateBioSigilControlcode(string $value): bool {
    if (empty($value)) {
        return false;
    }

    $referenceNumberMinLength = 2;
    $referenceNumberMaxLength = 3;
    $isoPartLength = 7;
    $isoPart = mb_substr($value, 0, $isoPartLength);
    $referenceNumber = mb_substr($value, $isoPartLength);

    if (mb_strlen($isoPart) !== $isoPartLength
        || mb_strlen($referenceNumber) > $referenceNumberMaxLength
        || mb_strlen($referenceNumber) < $referenceNumberMinLength
    ) {
        return false;
    }

    if (is_numeric($isoPart) || !is_numeric($referenceNumber)) {
        return false;
    }

    if (mb_substr($isoPart, 2, 1) !== "-" || mb_substr($isoPart, 6, 1) !== "-") {
        return false;
    }

    return true;
}