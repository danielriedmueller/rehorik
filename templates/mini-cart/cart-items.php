<?php $cart = WC()->cart; ?>
<div class="cart-content-items">
    <?php if (!$cart->is_empty()): ?>
        <?php foreach ($cart->get_cart() as $cart_item_key => $cart_item): ?>
            <div class="cart-item">
                <?php $product = $cart_item['data'] ?>
                <img alt="mini-cart-product-image"
                     src="<?php echo wp_get_attachment_url($product->get_image_id()); ?>"/>
                <div>
                    <a href="<?= $product->get_permalink($cart_item); ?>"><?= $product->get_title() ?></a>
                    <div><?= $cart->get_product_price($product) ?></div>
                    <?php
                    if ($cart_item['data']->is_type('variation') && is_array($cart_item['variation'])) {
                        foreach ($cart_item['variation'] as $name => $value) {
                            $taxonomy = wc_attribute_taxonomy_name(str_replace('attribute_pa_', '',
                                urldecode($name)));

                            if (taxonomy_exists($taxonomy)) {
                                $term = get_term_by('slug', $value, $taxonomy);
                                if (!is_wp_error($term) && $term && $term->name) {
                                    $value = $term->name;
                                }
                            } else {
                                $value = apply_filters('woocommerce_variation_option_name', $value, null,
                                    $taxonomy, $cart_item['data']);
                            }
                            echo '<div>' . $value . '</div>';
                        }
                    }
                    ?>
                </div>
                <div><?php
                    woocommerce_quantity_input(
                        array(
                            'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                            'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                            'input_value' => isset( $cart_item['quantity'] ) ? wc_stock_amount( wp_unslash( $cart_item['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                        )
                    );
                    ?></div>
                <div>
                    <?= $cart->get_product_subtotal($product, $cart_item['quantity']) ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div>Keine Artikel im Warenkorb</div>
    <?php endif; ?>
</div>
