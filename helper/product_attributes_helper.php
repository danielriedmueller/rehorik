<?php
require_once('product_sigil_helper.php');

// Attributes
define('STRENGTH_ATTRIBUTE_SLUG', 'pa_staerke');
define('VARIETIES_ATTRIBUTE_SLUG', 'pa_sorte');
define('GRAPE_VARIETY_ATTRIBUTE_SLUG', 'pa_rebsorte');
define('AUSBAU_ATTRIBUTE_SLUG', 'pa_ausbau');
define('HERSTELLUNG_ATTRIBUTE_SLUG', 'pa_herstellung');
define('MILCHART_ATTRIBUTE_SLUG', 'pa_milchart');
define('FETT_ATTRIBUTE_SLUG', 'pa_fett');
define('FLAVOUR_ATTRIBUTE_SLUG', 'pa_aromen');
define('FLAVOUR_VARIETY_ATTRIBUTE_SLUG', 'pa_aromenvielfalt');
define('BEAN_COMPOSITION_ATTRIBUTE_SLUG', 'pa_bohnenkompositionen');
define('ORIGIN_COUNTRY_ATTRIBUTE_SLUG', 'pa_herkunft');
define('REGION_ATTRIBUTE_SLUG', 'pa_region');
define('PRODUCT_OF_MONTH_ATTRIBUTE_SLUG', 'pa_product-of-month');
define('BIOSIGIL_ATTRIBUTE_SLUG', 'pa_biosiegel');
define('ALCOHOL_ATTRIBUTE_SLUG', 'pa_alkoholgehalt');
define('WEIGHT_SLUG', 'weight');
define('WEIGHT_ATTRIBUTE_SLUG', 'pa_gewicht');
define('FILLING_QUANTITY_ATTRIBUTE_SLUG', 'pa_fuellmenge');
define('WINERY_ATTRIBUTE_SLUG', 'pa_weingut');
define('MANUFACTURER_ATTRIBUTE_SLUG', 'pa_hersteller');
define('GIFT_CONTENT_ATTRIBUTE_SLUG', 'pa_inhalt-praesentkarton');

// In $productAttributes array, slugs are prefixed by wordpress
define('ATTRIBUTE_SLUG_PREFIX', 'attribute_');

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

// TODO Remove
function getOsternPasstZu($product) {
    if ($product->get_id() === 18913) {
        return "Brunch";
    }

    if ($product->get_id() === 18924) {
        return "Fisch";
    }

    if ($product->get_id() === 18929) {
        return "Lamm";
    }

    if ($product->get_id() === 18914) {
        return "Grillen";
    }

    return "Früstück";
}

// TODO Remove
function getOsternOrder($product) {
    if ($product->get_id() === 18913) {
        return 4;
    }

    if ($product->get_id() === 18924) {
        return 1;
    }

    if ($product->get_id() === 18929) {
        return 2;
    }

    if ($product->get_id() === 18914) {
        return 3;
    }

    return 0;
}