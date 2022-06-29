<?php
require_once('product_sigil_helper.php');

// Attributes
const STRENGTH_ATTRIBUTE_SLUG = 'pa_staerke';
const VARIETIES_ATTRIBUTE_SLUG = 'pa_sorte';
const GRAPE_VARIETY_ATTRIBUTE_SLUG = 'pa_rebsorte';
const AUSBAU_ATTRIBUTE_SLUG = 'pa_ausbau';
const HERSTELLUNG_ATTRIBUTE_SLUG = 'pa_herstellung';
const MILCHART_ATTRIBUTE_SLUG = 'pa_milchart';
const FLAVOUR_ATTRIBUTE_SLUG = 'pa_aromen';
const FLAVOUR_VARIETY_ATTRIBUTE_SLUG = 'pa_aromenvielfalt';
const BEAN_COMPOSITION_ATTRIBUTE_SLUG = 'pa_bohnenkompositionen';
const ORIGIN_COUNTRY_ATTRIBUTE_SLUG = 'pa_herkunft';
const REGION_ATTRIBUTE_SLUG = 'pa_region';
const GUETESIEGEL_ATTRIBUTE_SLUG = 'pa_guetesiegel';
const BIOSIGIL_ATTRIBUTE_SLUG = 'pa_biosiegel';
const ALCOHOL_ATTRIBUTE_SLUG = 'pa_alkoholgehalt';
const VINTAGE_ATTRIBUTE_SLUG = 'pa_jahrgang';
const WEIGHT_SLUG = 'weight';
const WEIGHT_ATTRIBUTE_SLUG = 'pa_gewicht';
const FILLING_QUANTITY_ATTRIBUTE_SLUG = 'pa_fuellmenge';
const WINERY_ATTRIBUTE_SLUG = 'pa_weingut';
const GOES_WITH_ATTRIBUTE_SLUG = 'pa_passt-zu';
const QUALITY_NAME_ATTRIBUTE_SLUG = 'pa_qualitaetsbezeichnung';
const MANUFACTURER_ATTRIBUTE_SLUG = 'pa_hersteller';
const GIFT_CONTENT_ATTRIBUTE_SLUG = 'pa_inhalt-praesentkarton';

// In $productAttributes array, slugs are prefixed by wordpress
const ATTRIBUTE_SLUG_PREFIX = 'attribute_';

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