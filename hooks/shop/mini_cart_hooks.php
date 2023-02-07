<?php
// Display stripe payment request button in mini cart
add_action('woocommerce_widget_shopping_cart_buttons', [WC_Stripe_Payment_Request::instance(), 'display_payment_request_button_html'], 1);