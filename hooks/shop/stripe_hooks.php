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

// Display stripe payment request button in checkout
remove_action('woocommerce_checkout_before_customer_details', [WC_Stripe_Payment_Request::instance(), 'display_payment_request_button_html'], 1);
remove_action('woocommerce_checkout_before_customer_details', [WC_Stripe_Payment_Request::instance(), 'display_payment_request_button_separator_html'], 2);
add_action('woocommerce_review_order_before_submit', [WC_Stripe_Payment_Request::instance(), 'display_payment_request_button_html'], 1);

// Display stripe payment request button in single product
remove_action('woocommerce_after_add_to_cart_quantity', [WC_Stripe_Payment_Request::instance(), 'display_payment_request_button_html'], 1);
remove_action('woocommerce_after_add_to_cart_quantity', [WC_Stripe_Payment_Request::instance(), 'display_payment_request_button_separator_html'], 2);
add_action('woocommerce_single_product_summary', [WC_Stripe_Payment_Request::instance(), 'display_payment_request_button_html'], 30);
