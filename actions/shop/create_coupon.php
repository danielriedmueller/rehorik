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

    foreach ($order->get_items() as $item) {
        // Prevent create multiple coupons
        if ($item->meta_exists(ORDER_ITEM_COUPON_CODE)) {
            continue;
        }

        /** @var WC_Product $product */
        $product = $item->get_product();

        $couponCatId = get_term_by('slug', COUPON_CATEGORY_SLUG, 'product_cat')->term_id;
        if ($product->is_virtual() && in_array($couponCatId, $product->get_category_ids())) {
            /** @var WC_Coupon $coupon */

            // Create coupon for each quantity
            for ($i = 0; $i < $item->get_quantity(); $i++) {
                $couponCode = Reh_Online_Coupon::createCoupon($product->get_price(), $order_id);
                $item->add_meta_data(ORDER_ITEM_COUPON_CODE, $couponCode);
            }

            $item->save_meta_data();
            $item->save();
        }
    }
}, 10, 1);
