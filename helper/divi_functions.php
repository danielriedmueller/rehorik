<?php
function et_show_cart_total( $args = array() ) {
    if ( ! class_exists( 'woocommerce' ) || ! WC()->cart ) {
        return;
    }

    $defaults = array(
        'no_text' => false,
    );

    $args = wp_parse_args( $args, $defaults );

    $items_number = WC()->cart->get_cart_contents_count();

    $url = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : WC()->cart->get_cart_url();

    printf(
        '<a href="%1$s" class="rehorik-cart-info et-cart-info">
				<span></span>%2$s
			</a>',
        esc_url( $url ),
        (!$args['no_text'] && $items_number > 0 ? "<div class='rehorik-cart-info-number'>${items_number}</div>" : '')
    );
}