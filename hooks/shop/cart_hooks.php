<?php
remove_action( 'woocommerce_before_cart', 'woocommerce_output_all_notices', 10 );
add_action( 'rehorik_cart_notices', 'woocommerce_output_all_notices', 10 );

// Display stripe payment request button in cart
remove_action('woocommerce_proceed_to_checkout', [WC_Stripe_Payment_Request::instance(), 'display_payment_request_button_html'], 1);
add_action('woocommerce_proceed_to_checkout', [WC_Stripe_Payment_Request::instance(), 'display_payment_request_button_html'], 20);
remove_action('woocommerce_proceed_to_checkout', [WC_Stripe_Payment_Request::instance(), 'display_payment_request_button_separator_html'], 2);