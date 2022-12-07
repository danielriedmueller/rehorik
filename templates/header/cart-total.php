<?php
if (!class_exists('woocommerce') || !WC()->cart) {
    return;
}
$contentCount = WC()->cart->get_cart_contents_count();
?>
<?php if (is_cart() || is_checkout()) : ?>
    <a href="<?= wc_get_cart_url() ?>" id="rehorik-cart"><div class='rehorik-cart-info-number'><?php echo $contentCount > 0 ? $contentCount : "" ?></div></a>
<?php else : ?>
    <div id="rehorik-cart"><div class='rehorik-cart-info-number'><?php echo $contentCount > 0 ? $contentCount : "" ?></div></div>
<?php endif; ?>