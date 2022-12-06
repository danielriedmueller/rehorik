<?php
$cart = WC()->cart;

/*
$products = [];
// Set limit
$limit = 3;

// Get customer $limit last orders
$customer_orders = wc_get_orders( array(
    'customer'  => get_current_user_id(),
    'limit'     => $limit
) );

// Count customers orders
$count = count( $customer_orders );

foreach ( $customer_orders as $customer_order ) {
    $order      = wc_get_order( $customer_order ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
    $item_count = $order->get_item_count() - $order->get_item_count_refunded();
    foreach ($order->get_items() as $item) {
        $products[] = $item->get_product();
    }
}
*/
?>
    <div id="rehorik-mini-cart" class="show">
        <div id="mini-cart-overlay"></div>
        <div class="mini-cart-content">
            <div>
                <div class="cart-content-info">
                    <div id="rehorik-mini-cart-update-message">Warenkorb wurde aktualisiert!</div>
                    <div><?= $cart->get_cart_contents_count() ?> Artikel</div>
                    <div><a href="<?= wc_get_cart_url() ?>">Warenkorb</a></div>
                </div>
                <div class="widget_shopping_cart_content"></div>
                <div class="cart-content-featured"></div>
            </div>
        </div>
    </div>
<?php
?>