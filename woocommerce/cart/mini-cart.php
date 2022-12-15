<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

use model\Reh_Mini_Cart_Item;

defined('ABSPATH') || exit;

$cart = WC()->cart;
do_action('woocommerce_before_mini_cart');
?>
<div class="mini-cart-stripes"><h2>Warenkorb</h2></div>
<div class="mini-cart-content-shopping">
    <div id="rehorik-mini-cart-update-message"><span>Warenkorb aktualisiert.</span></div>
    <?php if (!$cart->is_empty()) : ?>
        <ul class="rehorik-mini-cart-item-list">
            <?php
            do_action('woocommerce_before_mini_cart_contents');

            foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
                $item = Reh_Mini_Cart_Item::createFromWcCartItem($cart_item);
                if ($item && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true,
                        $cart_item, $cart_item_key)) {
                    ?>
                    <li class="rehorik-mini-cart-item">
                        <div class="mini-cart-item-thumbnail">
                            <?php if ($item->hasPermalink()) : ?>
                                <a href="<?php echo esc_url($item->getPermalink()); ?>">
                                    <?= $item->getThumbnail(); ?>
                                </a>
                            <?php else : ?>
                                <?= $item->getThumbnail(); ?>
                            <?php endif; ?>
                        </div>
                        <div class="mini-cart-item-details">
                            <div>
                                <div>
                                    <?php if ($item->hasPermalink()) : ?>
                                        <a href="<?php echo esc_url($item->getPermalink()); ?>">
                                            <?= $item->getName(); ?>
                                        </a>
                                    <?php else : ?>
                                        <?= $item->getName(); ?>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <?php foreach ($item->getViewAttributes() as $attribute) {
                                        echo $attribute;
                                    } ?>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <?php
                                    $product_quantity = woocommerce_quantity_input(
                                        array(
                                            'input_name' => $cart_item_key,
                                            'input_value' => $cart_item['quantity'],
                                            'max_value' => $item->getMaxPurchaseQuantity(),
                                            'min_value' => '0',
                                            'product_name' => $item->getName(),
                                        ),
                                        $item->getProduct(),
                                        false
                                    );
                                    echo apply_filters('woocommerce_widget_cart_item_quantity',
                                        '<span class="quantity">' . $product_quantity . '</span>', $cart_item,
                                        $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                    ?>
                                </div>
                                <div><?= $item->getPrice() ?></div>
                            </div>
                        </div>
                    </li>
                    <?php
                }
            }

            do_action('woocommerce_mini_cart_contents');
            ?>
        </ul>

        <div class="mini-cart-subtotal">
            <div>
                <span>Zwischensumme:</span>
                <?php wc_cart_totals_subtotal_html(); ?>
            </div>

            <div>
                <?php wc_cart_totals_shipping_html(); ?>
                <div class="rehorik-shipping-rest-amount">
                    <?php do_action('render_rest_amount_for_free_shipping'); ?>
                </div>
            </div>

            <?php do_action('woocommerce_widget_shopping_cart_before_buttons'); ?>
        </div>

        <div class="mini-cart-total">
            <span>Gesamt</span>
            <?php wc_cart_totals_order_total_html(); ?>
        </div>

        <div class="mini-cart-buttons">
            <?php do_action('woocommerce_widget_shopping_cart_buttons'); ?>
            <?php do_action('woocommerce_widget_shopping_cart_after_buttons'); ?>
        </div>

    <?php else : ?>
        <p class="woocommerce-mini-cart__empty-message"><?php esc_html_e('No products in the cart.',
                'woocommerce'); ?></p>
    <?php endif; ?>

    <?php do_action('woocommerce_after_mini_cart'); ?>
</div>
