<?php

/**
 * For creating coupon code after purchasing coupon.
 */
add_action('woocommerce_order_status_completed', function ($order_id): void {
    if (!$order_id) {
        return;
    }

    if (!$order = new WC_Order($order_id)) {
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
                /** @var WC_Coupon $coupon */
                $couponCode = $couponFactory->createCoupon($product->get_price());
                $item->add_meta_data(ORDER_ITEM_COUPON_CODE, $couponCode);
                $item->save_meta_data();
                $item->save();
            }
        }
    }
}, 10, 1);

/**
 * Remove coupon if order has been cancelled
 */
add_action('woocommerce_order_status_cancelled', function ($order_id): void {
    if (!$order_id) {
        return;
    }

    if (!$order = new WC_Order($order_id)) {
        return;
    }

    $itemsWithCouponCode = array_filter($order->get_items(), function ($orderItem) {
        return $orderItem->get_meta(ORDER_ITEM_COUPON_CODE);
    });

    if (sizeof($itemsWithCouponCode) > 0) {
        $couponFactory = new Reh_Create_Coupon();
        foreach ($itemsWithCouponCode as $orderItem) {
            $couponCode = $orderItem->get_meta(ORDER_ITEM_COUPON_CODE);

            if (!$couponCode) {
                // TODO send exception mail
            }

            $couponFactory->deleteCoupon($couponCode);
        }
    }
}, 10, 1);
