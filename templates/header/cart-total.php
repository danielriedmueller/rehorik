<?php
if (!class_exists( 'woocommerce') || !WC()->cart) {
    return;
}
?>
<div id="rehorik-mini-cart">
<a href="<?= wc_get_cart_url() ?>" class="rehorik-cart-info"><div class='rehorik-cart-info-number'><?php echo WC()->cart->get_cart_contents_count() > 0 ? WC()->cart->get_cart_contents_count() : "" ?></div></a>

<?php
$cart = WC()->cart;
$subtotal = $cart->get_cart_subtotal();
$total = $cart->get_total();
foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
    $product = $cart_item['data'];
    $product_id = $cart_item['product_id'];
    $variation_id = $cart_item['variation_id'];
    $quantity = $cart_item['quantity'];
    $price = WC()->cart->get_product_price( $product );
    $subtotal = WC()->cart->get_product_subtotal( $product, $cart_item['quantity'] );
    $link = $product->get_permalink( $cart_item );
    // Anything related to $product, check $product tutorial
    $attributes = $product->get_attributes();
    $whatever_attribute = $product->get_attribute( 'whatever' );
    $whatever_attribute_tax = $product->get_attribute( 'pa_whatever' );
    $any_attribute = $cart_item['variation']['attribute_whatever'];
    $meta = wc_get_formatted_cart_item_data( $cart_item );
}
?>
<div id="rehorik-mini-cart-content">
    <div>
        <?php foreach ($cart->get_cart() as $cart_item_key => $cart_item): ?>
            <?php $product = $cart_item['data'] ?>
            <img alt="mini-cart-product-image" src="<?php echo wp_get_attachment_url( $product->get_image_id() ); ?>" />
            <a href="<?= $product->get_permalink( $cart_item ); ?>"><?= $product->get_title() ?></a>
            <span><?= $cart->get_product_price($product) ?></span>
            <span><?= $cart_item['quantity'] ?></span>
        <?php endforeach;?>
        <div>
            <?= $subtotal ?>
            <?= $total ?>
            <a href="<?= wc_get_cart_url() ?>">Warenkorb</a>
            <a href="<?= wc_get_checkout_url() ?>">Kasse</a>
        </div>
    </div>
</div>
</div>
