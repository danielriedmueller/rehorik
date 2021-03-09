<?php
if (!class_exists( 'woocommerce') || !WC()->cart) {
    return;
}

$items_number = WC()->cart->get_cart_contents_count();
$items_number = $items_number > 0 ? "<div class='rehorik-cart-info-number'>${items_number}</div>" : "";
$url = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : WC()->cart->get_cart_url();
$url = esc_url($url);

?>
<a href="<?= $url ?>" class="rehorik-cart-info">
    <span></span><?= $items_number ?>
</a>
