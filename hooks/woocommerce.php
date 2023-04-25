<?php
require_once('shop/single_product_hooks.php');
require_once('shop/cart_hooks.php');
require_once('shop/products_gallery_hooks.php');

/**
 * @depreacated
 * Replaced with plugin
 * Legacy code until all coupons are used or updated
 */
function action_woocommerce_checkout_create_order_coupon_item( $item, $code, $coupon, $order ) {
    if ($coupon instanceof \WC_Coupon) {
        if ($coupon->get_discount_type() === 'fixed_cart' && !in_array($coupon->get_code(),SPECIAL_COUPON_CODES)) {
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

add_filter( 'woocommerce_add_to_cart_fragments', function ($fragments) {
    $fragments[ '.rehorik-cart-info-number' ] = '<div class="rehorik-cart-info-number">' . (WC()->cart->get_cart_contents_count() > 0 ? WC()->cart->get_cart_contents_count() : "") . '</div>';

    return $fragments;
});
