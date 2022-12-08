<?php ?>
<div id="rehorik-mini-cart">
    <div id="mini-cart-overlay"></div>
    <div class="mini-cart-content">
        <div>
            <div id="mini-cart-close">Weiter einkaufen</div>
            <div class="cart-content-featured">
                <div>Nochmal kaufen?</div>
                <?php get_template_part('templates/featured/reorder') ?>
            </div>
            <div class="widget_shopping_cart_content"><?php wc_get_template('cart/mini-cart'); ?></div>
        </div>
    </div>
</div>
