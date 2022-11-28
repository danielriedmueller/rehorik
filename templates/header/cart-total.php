<?php
if (!class_exists('woocommerce') || !WC()->cart) {
    return;
}
$contentCount = WC()->cart->get_cart_contents_count();
?>
<div id="rehorik-mini-cart">
    <input id="mini-cart-button" type="checkbox">
    <div class="rehorik-cart-info">
        <div class='rehorik-cart-info-number'><?php echo $contentCount > 0 ? $contentCount : "" ?></div>
    </div>
    <?php get_template_part('templates/header/mini-cart'); ?>
</div>
