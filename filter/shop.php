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
 * Bike delivery shipping method only available for products with category lieferservice
 * Standard delivery shipping method only available for products with category onlineshop or
 * virtual events wich have degustation package (product is not virtual in this case)
 */
add_filter('woocommerce_package_rates', function ($rates) {
    $unsetBikeShipping = false;
    $unsetStandardShipping = false;

    foreach (WC()->cart->get_cart() as $values) {
        if (!isItCategory($values['data'], DELIVERY_CATEGORY_SLUG)) {
            $unsetBikeShipping = true;
        }

        if (!isItCategory($values['data'], ONLINESHOP_CATEGORY_SLUG)
            && !isItCategory($values['data'], VIRTUAL_EVENTS_CATEGORY_SLUG)) {
            $unsetStandardShipping = true;
        }
    }

    if ($unsetBikeShipping || $unsetStandardShipping) {
        $rates = array_filter($rates, function ($rate) use ($unsetStandardShipping, $unsetBikeShipping) {
            if (($rate->method_id === DELIVERY_SHIPPING_METHOD
                    || $rate->method_id === FREE_DELIVERY_SHIPPING_METHOD)
                && $unsetBikeShipping) {
                return false;
            }

            if (($rate->method_id === STANDARD_SHIPPING_METHOD
                    || $rate->method_id === FREE_STANDARD_SHIPPING_METHOD)
                && $unsetStandardShipping) {
                return false;
            }

            return true;
        });
    }

    return $rates;
});

/**
 * only copy opening php tag if needed
 * Displays shipping estimates for WC shipping rates
 */
add_filter('woocommerce_cart_shipping_method_full_label', function($label, $method) {
    $label .= '<br /><small>';

    if ($method->method_id === FREE_DELIVERY_SHIPPING_METHOD
        || $method->method_id === DELIVERY_SHIPPING_METHOD) {
        $label .= 'DI. und DO. ab 13 Uhr ';
    } else {
        $label .= '2-3 Tage versandfertig';
    }

    $label .= '</small>';
    return $label;
}, 10, 2 );
