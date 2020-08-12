<?php ?>
<div class="rehorik-coupon-container">
    <?php if ( wc_coupons_enabled() ) { ?>
        <div class="rehorik-coupon">
            <label>
                <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="Gutscheincode eingeben" />
                <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>">Einlösen</button>
            </label>
            <?php do_action( 'woocommerce_cart_coupon' ); ?>
        </div>
    <?php } ?>
    <div class="rehorik-update-cart">
        <button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
        <?php do_action( 'woocommerce_cart_actions' ); ?>
        <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
    </div>
</div>