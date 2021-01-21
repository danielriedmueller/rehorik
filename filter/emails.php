<?php
/**
 * Add a custom email to the list of emails WooCommerce should load
 *
 * @param array $email_classes available email classes
 * @return array filtered available email classes
 * @since 0.1
 */
function split_order_woocommerce_email($email_classes) {
    require('../includes/class-wc-delivery-order-email.php');
    require('../includes/class-wc-shipping-order-email.php');
    $email_classes['WC_Delivery_Order_Email'] = new WC_Delivery_Order_Email();
    $email_classes['WC_Shipping_Order_Email'] = new WC_Shipping_Order_Email();

    add_option('rh_delivery_email', DELIVERY_ORDER_EMAIL);

    return $email_classes;
}
add_filter('woocommerce_email_classes', 'split_order_woocommerce_email', 10, 1);