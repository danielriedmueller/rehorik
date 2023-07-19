<?php
// Don't load directly.
if (!defined('ABSPATH')) {
    die('-1');
}

if (!class_exists('WC_Stripe_Payment_Request')) {
    return;
}

// Display stripe payment request button in cart
remove_action('woocommerce_proceed_to_checkout', [WC_Stripe_Payment_Request::instance(), 'display_payment_request_button_html'], 1);
add_action('woocommerce_proceed_to_checkout', [WC_Stripe_Payment_Request::instance(), 'display_payment_request_button_html'], 20);
remove_action('woocommerce_proceed_to_checkout', [WC_Stripe_Payment_Request::instance(), 'display_payment_request_button_separator_html'], 2);
