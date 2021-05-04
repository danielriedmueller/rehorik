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
 * @param $full_label
 * @param $method
 * @return string
 */
/*
function remove_shipping_method_label($full_label, $method) {
    $label = "";
    $has_cost = 0 < $method->cost;
    $hide_cost = !$has_cost && in_array($method->get_method_id(), array('free_shipping', 'local_pickup'), true);

    if ($has_cost && !$hide_cost) {
        if (WC()->cart->display_prices_including_tax()) {
            $label .= wc_price($method->cost + $method->get_shipping_tax());
            if ($method->get_shipping_tax() > 0 && !wc_prices_include_tax()) {
                $label .= ' <small>' . WC()->countries->inc_tax_or_vat() . '</small>';
            }
        } else {
            $label .= ': ' . wc_price($method->cost);
            if ($method->get_shipping_tax() > 0 && wc_prices_include_tax()) {
                $label .= ' <small>' . WC()->countries->ex_tax_or_vat() . '</small>';
            }
        }

        return $label;
    }

    return $full_label;
}
add_filter('woocommerce_cart_shipping_method_full_label', 'remove_shipping_method_label', 10, 2);
*/

/**
 * Remove event coupon payment (or actually cheque) gateway from other product categories
 */
function allow_coupon_payment_gateway_only_for_events($available_gateways)
{
    if (!is_checkout()) return $available_gateways;

    $unset = false;
    $cat = get_term_by( 'slug', TICKET_CATEGORY_SLUG, 'product_cat' );

    foreach (WC()->cart->get_cart_contents() as $key => $values) {
        $terms = get_the_terms($values['product_id'], 'product_cat');
        foreach ($terms as $term) {
            if ($cat->term_id !== $term->term_id) {
                $unset = true;
                break;
            }
        }
    }
    if ($unset == true) unset($available_gateways['cheque']);

    return $available_gateways;
}

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
 * Standard delivery shipping method only available for products with category onlineshop
 */
add_filter('woocommerce_package_rates', function ($rates) {
    $unsetBikeShipping = false;
    $unsetStandardShipping = false;

    foreach (WC()->cart->get_cart() as $values) {
        if (!isItCategory($values['data'], DELIVERY_CATEGORY_SLUG)) {
            $unsetBikeShipping = true;
        }

        if (!isItCategory($values['data'], ONLINESHOP_CATEGORY_SLUG)) {
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
