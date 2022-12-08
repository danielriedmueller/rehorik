<?php
$cart = WC()->cart;
// Set limit
$limit = 3;

// Get customer $limit last orders
$customer_orders = wc_get_orders([
    'customer' => get_current_user_id(),
    'limit' => $limit,
]);

$items = [];
foreach ($customer_orders as $customer_order) {
    foreach (wc_get_order($customer_order)->get_items() as $item) {
        $items[] = $item;





    }
}
?>
<ul>
    <?php foreach ($items as $order_item) {
        $product = $order_item->get_product();
        if ($product && $product->exists()) {
            $product_name = $product->get_name();
            $thumbnail = $product->get_image();
            $product_price = $product->get_price();
            $product_permalink = $product->get_permalink();

            if ($product->get_type() === 'variation') {
                $product_id = $product->get_parent_id();
                $variation_id = $order_item->get_variation_id();
                $attributes = $order_item->get_formatted_meta_data();
            } else {
                $product_id = $product->get_id();
                $variation_id = 0;
                $attributes = [];
            } ?>
            <li>
                <?php if (empty($product_permalink)) : ?>
                    <?php echo $thumbnail . wp_kses_post($product_name); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <?php else : ?>
                    <a href="<?php echo esc_url($product_permalink); ?>">
                        <?php echo $thumbnail . wp_kses_post($product_name); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </a>
                <?php endif; ?>
                <div><?= $product_name ?></div>
                <div><?= $product_price ?></div>
                <div>
                    <?php foreach ($attributes as $attribute) {
                        echo sprintf('%s: %s', $attribute->display_key, $attribute->display_value);
                    } ?>
                </div>
                <button class="add-to-cart-recent-order-item"
                        data-product-id="<?= $product_id ?>"
                        data-variation-id="<?= $variation_id ?>"
                        data-attributes='<?= json_encode(array_values(array_map(function ($attribute
                        ) {
                            return [
                                'name' => ATTRIBUTE_SLUG_PREFIX . $attribute->key,
                                'value' => $attribute->value,
                            ];
                        }, $attributes))) ?>'
                ></button>
            </li>
        <?php }
    } ?>
</ul>