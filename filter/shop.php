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

/**
 * Set delivery option to yes, if previous page was delivery category page
 */
function set_delivery_service_variation_default_value($args)
{
    if ($args['attribute'] === DELIVERY_ATTRIBUTE_SLUG) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];

            if (substr_count($referer, DELIVERY_CATEGORY_URL) === 1) {
                $args['selected'] = 'ja';
            }
        }
    }

    return $args;
}
add_filter('woocommerce_dropdown_variation_attribute_options_args', 'set_delivery_service_variation_default_value', 10, 1);