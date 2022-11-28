<?php
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
        /** @var WC_Order_Item_Product $item */
        $products[] = $item->get_product();
    }
}

if (empty($products)) {
    return;
}
?>
<ul>
    <?php foreach ($products as $product): ?>
        <li><?php get_template_part('templates/featured/item', null, ['product' => $product, 'description' => false]) ?></li>
    <?php endforeach; ?>
</ul>
