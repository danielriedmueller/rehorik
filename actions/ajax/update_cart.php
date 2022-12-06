<?php
add_action('wp_ajax_rehorik_ajax_update_cart', 'rehorik_update_cart');
add_action('wp_ajax_nopriv_rehorik_ajax_update_cart', 'rehorik_update_cart');

function rehorik_update_cart()
{
    $key = $_POST['cart_item_key'];
    $value = $_POST['cart_item_value'];
    WC()->cart->set_quantity( $key, $value );
    /*
    $key = sanitize_text_field($_POST['key']);
    $number = intval(sanitize_text_field($_POST['number']));
    $cart = array(
        'count' => 0,
        'total' => 0,
        'item_price' => 0,
    );
    if($key && $number>0 && wp_verify_nonce( $_POST['security'], 'woo-amc-security' )){
        WC()->cart->set_quantity( $key, $number );
        $items = WC()->cart->get_cart();
        $cart = array();
        $cart['count'] = WC()->cart->cart_contents_count;
        $cart['total'] = WC()->cart->get_cart_total();
        $cart['item_price'] = wc_price($items[$key]['line_total']);
    }
    echo json_encode( $cart );
    wp_die();
    */
}
