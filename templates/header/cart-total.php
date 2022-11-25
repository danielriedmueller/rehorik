<?php
if (!class_exists('woocommerce') || !WC()->cart) {
    return;
}
$cart = WC()->cart;
?>
<div id="rehorik-mini-cart">
    <input id="mini-cart-button" type="checkbox">
    <div class="rehorik-cart-info">
        <div class='rehorik-cart-info-number'><?php echo WC()->cart->get_cart_contents_count() > 0 ? $cart->get_cart_contents_count() : "" ?></div>
    </div>
    <div id="rehorik-mini-cart-content">
        <div>
            <div class="cart-content-info">
                <div><?= $cart->get_cart_contents_count() ?> Artikel</div>
                <div><a href="<?= wc_get_cart_url() ?>">Warenkorb</a></div>
            </div>
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
                                        $taxonomy = wc_attribute_taxonomy_name(str_replace('attribute_pa_', '', urldecode($name)));

                                        if (taxonomy_exists($taxonomy)) {
                                            $term = get_term_by('slug', $value, $taxonomy);
                                            if (!is_wp_error($term) && $term && $term->name) {
                                                $value = $term->name;
                                            }
                                        } else {
                                            $value = apply_filters('woocommerce_variation_option_name', $value, null, $taxonomy, $cart_item['data']);
                                        }

                                        echo '<div>' . $value . '</div>';
                                    }
                                }
                                ?>
                            </div>
                            <div>#<?= $cart_item['quantity'] ?></div>
                            <div>
                                <?= $cart->get_product_subtotal($product, $cart_item['quantity']) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div>Keine Artikel im Warenkorb</div>
                <?php endif; ?>
            </div>
            <div class="cart-content-total">
                <div>Versandkosten: <?= $cart->get_cart_shipping_total() ?> </div>
                <div>Gesamtsumme: <?= $cart->get_total() ?></div>
            </div>
            <div><a href="<?= wc_get_checkout_url() ?>">zur Kasse</a></div>
        </div>
    </div>
</div>
