<?php
if (!class_exists('woocommerce') || !WC()->cart) {
    return;
}
$contentCount = WC()->cart->get_cart_contents_count();
$showLink = is_cart() || is_checkout();
?>
<?php if ($showLink) : ?>
    <a href="<?= wc_get_cart_url() ?>" class="rehorik-cart">
<?php else : ?>
    <div role="button" class="rehorik-cart">
<?php endif; ?>
        <div class="rehorik-cart-info">
            <div class='rehorik-cart-info-number'><?php echo $contentCount > 0 ? $contentCount : "" ?></div>
        </div>
<?php if ($showLink) : ?>
    </a>
<?php else : ?>
    </div>
<?php endif; ?>
