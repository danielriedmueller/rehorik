<?php

add_action( 'wp_enqueue_scripts', 'my_enqueue_assets' );

function my_enqueue_assets() {

    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );

}

/* Custom Text Mobile Navi */
/* first remove the parent function */
function child_remove_parent_function() {
    remove_action( 'et_header_top', 'et_add_mobile_navigation' );
}
add_action( 'wp_loaded', 'child_remove_parent_function' );

/* now load new one with new custom name, to not conflict with parent function name */

/**
 * Hide shipping rates when free shipping is available.
 * Updated to support WooCommerce 2.6 Shipping Zones.
 *
 * @param array $rates Array of rates found for the package.
 * @return array
 */
function my_hide_shipping_when_free_is_available( $rates ) {
    $free = array();
    foreach ( $rates as $rate_id => $rate ) {
        if ( 'free_shipping' === $rate->method_id ) {
            $free[ $rate_id ] = $rate;
            break;
        }
    }
    return ! empty( $free ) ? $free : $rates;
}
add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100 );

/* ----------------------------------------------------------------------------------- */
// Add Divi Builder to TEC Post Types
/* ----------------------------------------------------------------------------------- */

function add_tec_post_types( $post_types ) {
    $post_types[] = 'tribe_events';
    $post_types[] = 'tribe_venue';
    $post_types[] = 'tribe_organizer';

    return $post_types;
}
add_filter( 'et_builder_post_types', 'add_tec_post_types' );


/*
 * EXAMPLE OF CHANGING ANY TEXT (STRING) IN THE EVENTS CALENDAR
 * See the codex to learn more about WP text domains:
 * http://codex.wordpress.org/Translating_WordPress#Localization_Technology
 * Example Tribe domains: 'tribe-events-calendar', 'tribe-events-calendar-pro'...
 */
function tribe_custom_theme_text ( $translation, $text, $domain ) {

    // Put your custom text here in a key => value pair
    // Example: 'Text you want to change' => 'This is what it will be changed to'
    // The text you want to change is the key, and it is case-sensitive
    // The text you want to change it to is the value
    // You can freely add or remove key => values, but make sure to separate them with a comma
    // This example changes the label "Venue" to "Location", and "Related Events" to "Similar Events"
    $custom_text = array(
        'Eintritt:' => 'Kosten:',
    );

    // If this text domain starts with "tribe-", "the-events-", or "event-" and we have replacement text
    if( (strpos($domain, 'tribe-') === 0 || strpos($domain, 'the-events-') === 0 || strpos($domain, 'event-') === 0) && array_key_exists($translation, $custom_text) ) {
        $translation = $custom_text[$translation];
    }
    return $translation;
}
add_filter('gettext', 'tribe_custom_theme_text', 20, 3);

?>