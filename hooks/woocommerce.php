<?php
require_once('shop/single_product_hooks.php');

function action_woocommerce_checkout_create_order_coupon_item( $item, $code, $coupon, $order ) {
    if ($coupon instanceof \WC_Coupon) {
        if ($coupon->get_discount_type() === 'fixed_cart') {
            $changes = $item->get_changes();
            if (isset($changes["discount"], $changes["discount_tax"])) {
                $discount_total = (float) $changes["discount"] + (float) $changes["discount_tax"];
                $coupon_amount = (float) $coupon->get_amount();

                $residual_value = $coupon_amount - $discount_total;
                if ($residual_value > 0) {
                    $coupon->set_amount($residual_value);
                } else {
                    $coupon->set_amount(0);
                    $coupon->set_usage_limit(1);
                }

                $coupon->save();
            }
        }
    }
}

add_action( 'woocommerce_checkout_create_order_coupon_item', 'action_woocommerce_checkout_create_order_coupon_item', 10, 4 );
