<?php
add_action('wp_ajax_rehorik_ajax_add_to_cart', 'rehorik_add_to_cart');
add_action('wp_ajax_nopriv_rehorik_ajax_add_to_cart', 'rehorik_add_to_cart');

function rehorik_add_to_cart()
{
    $product_id = absint($_POST['product_id']);
    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount(wp_unslash($_POST['quantity']));
    $product = wc_get_product($product_id);
    $variation_id = 0;
    $variation = array();

    if (!$product) {
        wp_send_json(['error' => true]);

        return;
    }

    $type = $product->get_type();

    if ('variation' === $product->get_type()) {
        $variation_id = $product_id;
        $product_id = $product->get_parent_id();
        $variation = $product->get_variation_attributes();
    }

    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    $product_status = get_post_status($product_id);

    if ($passed_validation && false !== WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation) && 'publish' === $product_status) {
        do_action('woocommerce_ajax_added_to_cart', $product_id);
        if ('yes' === get_option('ql_woocommerce_cart_redirect_after_add')) {
            wc_add_to_cart_message(array($product_id => $quantity), true);
        }
        WC_AJAX:: get_refreshed_fragments();
    } else {
        // If there was an error adding to the cart, redirect to the product page to show any errors.
        wp_send_json([
            'error' => true,
            'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id),
        ]);
    }
}
