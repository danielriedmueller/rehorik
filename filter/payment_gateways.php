<?php
add_filter('woocommerce_available_payment_gateways', function($available_gateways) {
    // Cash payment should be disallowed for non-company users
    if (in_array(PAYMENT_METHOD_CASH, $available_gateways)) {
        if (!isCashPaymentAllowed()) {
            unset($available_gateways[PAYMENT_METHOD_CASH]);
        }
    }

    // Direct transfer payment should be disallowed for event tickets
    if (!is_checkout()) {
        return $available_gateways;
    }

    $unset = false;
    foreach (WC()->cart->get_cart_contents() as $values) {
        $product = wc_get_product($values['product_id']);
        $eventCatId = get_term_by('slug', TICKET_CATEGORY_SLUG, 'product_cat')->term_id;
        if ($product->is_virtual() && in_array($eventCatId, $product->get_category_ids())) {
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

