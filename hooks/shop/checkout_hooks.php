<?php
// Display stripe payment request button in checkout
remove_action('woocommerce_checkout_before_customer_details', [WC_Stripe_Payment_Request::instance(), 'display_payment_request_button_html'], 1);
remove_action('woocommerce_checkout_before_customer_details', [WC_Stripe_Payment_Request::instance(), 'display_payment_request_button_separator_html'], 2);
add_action('woocommerce_review_order_before_submit', [WC_Stripe_Payment_Request::instance(), 'display_payment_request_button_html'], 1);
