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
            $couponCodes = [];
            if ($product->is_virtual() && in_array($couponCatId, $product->get_category_ids())) {
                $couponFactory = new Reh_Create_Coupon();
                /** @var WC_Coupon $coupon */
                $couponCodes[] = $couponFactory->createCoupon($product->get_price());
                $order->add_meta_data(ORDER_COUPON_CODE_PRODUCT, $couponCodes);
            }
        }

        $order->save_meta_data();
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

    foreach ($order->get_meta(ORDER_COUPON_CODE_PRODUCT) as $couponCode) {
        $couponFactory = new Reh_Create_Coupon();
        $couponFactory->deleteCoupon($couponCode);
    }
}, 10, 1);

