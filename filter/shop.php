<?php
/**
 * Adds class to body classes for shop page only.
 */
add_filter('body_class', function ($classes) {
    if (is_shop()) {
        return array_merge($classes, array('shop'));
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
 * Direct transfer payment should be disallowed for virtual products
 * and virtual events with degustation package (which is not virtual).
 */
function disallow_direct_transfer_payment_for_virtual_products($available_gateways)
{
    if (!is_checkout()) {
        return $available_gateways;
    }

    $unset = false;
    foreach (WC()->cart->get_cart_contents() as $values) {
        $product = wc_get_product($values['product_id']);
        if ($product->is_virtual()
            || isItCategory($values['data'], VIRTUAL_EVENTS_CATEGORY_SLUG)) {
            $unset = true;
            break;
        }
    }

    if ($unset === true) {
        unset($available_gateways[PAYMENT_METHOD_DIRECT_TRANSFER]);
    }

    return $available_gateways;
}
add_filter( 'woocommerce_available_payment_gateways', 'disallow_direct_transfer_payment_for_virtual_products');

/**
 * Add bike delivery shipping method
 */
add_filter('woocommerce_shipping_methods', function ($methods) {
    $methods[DELIVERY_SHIPPING_METHOD] = 'WC_Shipping_Bike';
    $methods[FREE_DELIVERY_SHIPPING_METHOD] = 'WC_Shipping_Free_Shipping_Bike';

    return $methods;
});

/**
 * Displays shipping estimates for WC shipping rates
 */
add_filter('woocommerce_cart_shipping_method_full_label', function($label, $method) {
    $label .= '<br /><small>';

    if ($method->method_id === FREE_DELIVERY_SHIPPING_METHOD
        || $method->method_id === DELIVERY_SHIPPING_METHOD) {
        $label .= 'DI. und DO. ab 13 Uhr ';
    } else {
        $label .= 'Lieferzeit: 3 - 5 Werktage';
    }

    $label .= '</small>';
    return $label;
}, 10, 2);

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