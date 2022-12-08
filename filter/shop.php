<?php
/**
 * Adds class to body classes for shop page only.
 */
add_filter('body_class', function ($classes) {
    if (function_exists('is_shop')) {
        if (is_shop()) {
            return array_merge($classes, array('shop'));
        }
    }

    return $classes;
});

add_filter('woocommerce_checkout_fields', function ($fields) {
    $fields['billing']['billing_address_1']['label'] = 'Straße und Hausnummer';
    $fields['shipping']['shipping_address_1']['label'] = 'Straße und Hausnummer';
    unset($fields['billing']['billing_address_2']);
    unset($fields['shipping']['shipping_address_2']);

    return $fields;
});

/**
 * Removes page title in content area.
 */
add_filter('woocommerce_show_page_title', function () {
    return false;
});

/**
 * Displays shipping estimates for WC shipping rates
 */
add_filter('woocommerce_cart_shipping_method_full_label', function($label) {
    return $label . '<br /><small>Lieferzeit: 3 - 5 Werktage</small>';
});

/**
 * Remove Ancient Custom Fields metabox from post editor
 * because it uses a very slow query meta_key sort query
 * so on sites with large postmeta tables it is super slow
 * and is rarely useful anymore on any site
 */
function s9_remove_post_custom_fields_metabox() {
    foreach ( get_post_types( '', 'names' ) as $post_type ) {
        remove_meta_box( 'postcustom' , $post_type , 'normal' );
    }
}
add_action( 'admin_menu' , 's9_remove_post_custom_fields_metabox' );

/**
 * Add to cart message
 */
add_filter( 'wc_add_to_cart_message_html', function( $message, $products ) {
    $url = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : WC()->cart->get_cart_url();
    $count = WC()->cart->get_cart_contents_count();
    return sprintf(
        '<div class="rehorik-add-to-cart-message"><span>Es %s <b>%s Artikel</b> in deinem Warenkorb</b></span><span><a href="%s"></a></span></div>',
        $count === 1 ? 'ist' : 'sind',
        $count,
        esc_url($url)
    );
}, 10, 2);

/*
* Reduce the strength requirement for woocommerce registration password.
* Strength Settings:
* 0 = Nothing = Anything
* 1 = Weak
* 2 = Medium
* 3 = Strong (default)
*/
add_filter( 'woocommerce_min_password_strength', 'wpglorify_woocommerce_password_filter', 10 );
function wpglorify_woocommerce_password_filter() {
    return 2; } //2 represent medium strength password
