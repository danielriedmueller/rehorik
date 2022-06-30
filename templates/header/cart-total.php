<?php
if (!class_exists( 'woocommerce') || !WC()->cart) {
    return;
}
?>
<a href="<?= wc_get_cart_url() ?>" class="rehorik-cart-info"><div class='rehorik-cart-info-number'><?php echo WC()->cart->get_cart_contents_count() > 0 ? WC()->cart->get_cart_contents_count() : "" ?></div></a>
