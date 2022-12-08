<?php
$current_customer_id = get_current_user_id();
$items = [];
if ($current_customer_id !== 0) {
    // Get customer $limit last orders
    $limit = 5;
    $customer_orders = wc_get_orders([
        'customer_id' => get_current_user_id(),
        'limit' => $limit,
    ]);
    foreach ($customer_orders as $customer_order) {
        foreach (wc_get_order($customer_order)->get_items() as $item) {
            $product = $item->get_product();
            if ($product && $product->exists()) {
                $product_name = $product->get_name();
                $thumbnail = $product->get_image();
                $product_price = $product->get_price();
                $product_permalink = $product->get_permalink();

                if ($product->get_type() === 'variation') {
                    $product_id = $product->get_parent_id();
                    $variation_id = $item->get_variation_id();
                    $attributes = $item->get_formatted_meta_data();
                    $data_attributes = json_encode(array_values(array_map(function ($attribute) {
                        return ['name' => ATTRIBUTE_SLUG_PREFIX . $attribute->key, 'value' => $attribute->value];
                    }, $attributes)));
                } else {
                    $product_id = $product->get_id();
                    $variation_id = 0;
                    $attributes = [];
                }

                // Does item already exist in $items?
                foreach ($items as $existing_item) {
                    if ($variation_id === 0) {
                        if ($product_id === $existing_item['product_id']) {
                            continue 2;
                        }
                    }

                    if ($variation_id === $existing_item['variation_id']
                        && $product_id === $existing_item['product_id']
                        && $data_attributes === $existing_item['data_attributes']) {
                        continue 2;
                    }
                }

                $items[] = [
                    'product_id' => $product_id,
                    'variation_id' => $variation_id,
                    'attributes' => $attributes,
                    'data_attributes' => $data_attributes,
                    'product_name' => $product_name,
                    'thumbnail' => $thumbnail,
                    'product_price' => $product_price,
                    'product_permalink' => $product_permalink,
                ];
            }
        }
    }
}
?>
<ul class="rehorik-mini-cart-item-list">
    <?php foreach ($items as $item) : ?>
        <li class="rehorik-mini-cart-item">
            <?php if (empty($item['product_permalink'])) : ?>
                <?php echo $item['thumbnail'] . wp_kses_post($item['product_name']); ?>
            <?php else : ?>
                <a href="<?php echo esc_url($item['product_permalink']); ?>">
                    <?php echo $item['thumbnail'] . wp_kses_post($item['product_name']); ?>
                </a>
            <?php endif; ?>
            <div><?= $item['product_price'] ?></div>
            <div>
                <?php foreach ($item['attributes'] as $attribute) {
                    echo sprintf('%s: %s', $attribute->display_key, $attribute->display_value);
                } ?>
            </div>
            <button class="add-to-cart-recent-order-item"
                    data-product-id="<?= $item['product_id'] ?>"
                    data-variation-id="<?= $item['variation_id'] ?>"
                    data-attributes='<?= $item['data_attributes'] ?>'
            ></button>
        </li>
    <?php endforeach; ?>
</ul>