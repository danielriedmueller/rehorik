<?php
if (!class_exists('woocommerce') || !WC()->cart) {
    return;
}
$contentCount = WC()->cart->get_cart_contents_count();
?>
<div id="rehorik-cart">
    <div class="rehorik-cart-info">
        <div class='rehorik-cart-info-number'><?php echo $contentCount > 0 ? $contentCount : "" ?></div>
    </div>
</div>
