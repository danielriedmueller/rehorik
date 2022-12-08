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
                <div id="mini-cart-close">Weiter einkaufen</div>
                <div class="cart-content-featured"></div>
                <div class="widget_shopping_cart_content"><?php wc_get_template('cart/mini-cart'); ?></div>
            </div>
        </div>
    </div>
<?php
?>