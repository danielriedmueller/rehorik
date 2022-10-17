<?php

/**
 * For offline event tickets sale.
 * Only company user accounts are allowed to buy tickets by cheque
 * In this case, set order to complete.
 */
add_action('woocommerce_thankyou', function ($order_id) {
    if (!$order_id) {
        return;
    }

    $order = new WC_Order($order_id);
    if (!$order) {
        return;
    }

    // Only paying cash, set order status
    if ($order->get_payment_method() !== PAYMENT_METHOD_CASH) {
        return;
    }

    $items = $order->get_items();

    $updateOrderStatus = false;
    foreach ($items as $item) {
        $product = $item->get_product();

        if ($product) {
            /**
             * @var WC_Product $product
             */
            $eventCatId = get_term_by('slug', TICKET_CATEGORY_SLUG, 'product_cat')->term_id;
            if ($product->is_virtual() && in_array($eventCatId, $product->get_category_ids())) {
                $updateOrderStatus = true;
            }
        }
    }

    if ($updateOrderStatus) {
        $order->update_status('completed');
    }
}, 10, 1);