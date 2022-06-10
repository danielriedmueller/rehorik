<?php

/**
 * Add custom data to Cart
 */
add_filter('woocommerce_add_cart_item_data', function ($cart_item_data, $product_id, $variation_id) {
    if (isset($_REQUEST[SUBSCRIPTION_COFFEE_MAHLGRAD])) {
        $cart_item_data[SUBSCRIPTION_COFFEE_MAHLGRAD] = sanitize_text_field($_REQUEST[SUBSCRIPTION_COFFEE_MAHLGRAD]);
    }

    return $cart_item_data;
}, 10, 3);

/**
 * Display information as Meta on Cart page
 */
add_filter('woocommerce_get_item_data', function ($item_data, $cart_item) {
    if (array_key_exists(SUBSCRIPTION_COFFEE_MAHLGRAD, $cart_item)) {
        $custom_details = $cart_item[SUBSCRIPTION_COFFEE_MAHLGRAD];

        $item_data[] = [
            'key' => 'Name',
            'value' => $custom_details,
        ];
    }

    return $item_data;
}, 10, 2);

add_action('woocommerce_checkout_create_order_line_item', function ($item, $cart_item_key, $values, $order) {
    if (array_key_exists(SUBSCRIPTION_COFFEE_MAHLGRAD, $values)) {
        $item->add_meta_data(SUBSCRIPTION_COFFEE_MAHLGRAD, $values[SUBSCRIPTION_COFFEE_MAHLGRAD]);
    }
}, 10, 4);
