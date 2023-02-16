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
    return $label . ' ' . getShippingDurationMessage();
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
