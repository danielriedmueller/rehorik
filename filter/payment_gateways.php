<?php

add_filter('woocommerce_available_payment_gateways', function($available_gateways) {
    // Cash payment should be disallowed for non-company users
    if (array_key_exists(PAYMENT_METHOD_CASH, $available_gateways)) {
        if (!isCashPaymentAllowed()) {
            unset($available_gateways[PAYMENT_METHOD_CASH]);
        }
    }

    if (!is_checkout()) {
        return $available_gateways;
    }

    // Direct transfer payment should be disallowed for virtual products
    $unset = false;
    foreach (WC()->cart->get_cart_contents() as $values) {
        $product = wc_get_product($values['product_id']);
        if ($product->is_virtual()) {
            $unset = true;
            break;
        }
    }

    if ($unset === true) {
        unset($available_gateways[PAYMENT_METHOD_DIRECT_TRANSFER]);
    }

    return $available_gateways;
});

/**
 * No local pickup if every product is virtual.
 */
add_filter('woocommerce_package_rates', function($rates) {
    if (!isset($rates['local_pickup'])) {
        return $rates;
    }

    $unset = true;
    foreach (WC()->cart->get_cart_contents() as $values) {
        $product = wc_get_product($values['product_id']);
        if (!$product->is_virtual()) {
            $unset = false;
            break;
        }
    }

    if ($unset === true) {
        unset($rates['local_pickup']);
    }

    return $rates;
});

/**
 * For cash payment, set order status to completed automatically.
 */
add_action('woocommerce_thankyou', function ($order_id) {
    if (!$order_id) {
        return;
    }

    if (!$order = new WC_Order($order_id)) {
        return;
    }

    // Only for payment gateway cash
    if ($order->get_payment_method() !== PAYMENT_METHOD_CASH) {
        return;
    }

    $order->update_status('completed');
    $order->save();
}, 10, 1);

/**
 * Only company user accounts are allowed to buy tickets by cash.
 */
function isCashPaymentAllowed(): bool
{
    $user = wp_get_current_user();
    $roles = ['administrator', 'shop_manager', 'shop_und_inhalt', 'produktpfleger'];

    foreach ($roles as $role) {
        $hasRole = in_array($role, $user->roles, true);
        if ($hasRole) {
            return true;
        }
    }

    return false;
}

