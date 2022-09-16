<?php

/**
 * For creating coupon code after purchasing coupon.
 */
add_action('woocommerce_order_status_completed', function ($order_id) {
    if (!$order_id) {
        return;
    }

    $order = new WC_Order($order_id);
    if (!$order) {
        return;
    }

    $items = $order->get_items();
    foreach ($items as $item) {
        $product = $item->get_product();

        if ($product) {
            /** @var WC_Product $product */
            $couponCatId = get_term_by('slug', COUPON_CATEGORY_SLUG, 'product_cat')->term_id;
            if ($product->is_virtual() && in_array($couponCatId, $product->get_category_ids())) {
                $couponFactory = new Reh_Create_Coupon();
                $couponFactory->createCoupon($product->get_price());
            }
        }
    }
}, 10, 1);
