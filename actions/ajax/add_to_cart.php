<?php
add_action('wp_ajax_rehorik_ajax_add_to_cart', 'rehorik_add_to_cart');
add_action('wp_ajax_nopriv_rehorik_ajax_add_to_cart', 'rehorik_add_to_cart');

function rehorik_add_to_cart()
{
    $product_id = absint($_POST['product_id']);
    $variation_id = absint($_POST['variation_id']);
    $product = wc_get_product($product_id);
    $attributes = $_POST['attributes'];
    $product_url = apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id);
    $error_contact_msg = sprintf(
        'Hoppla, hier gibts ein technisches Problem. Bitte schreibe uns eine Mail an <a href="%s">%s</a> und wir schauen uns die Sache an oder probiere es einfach später nochmal.',
        IT_SUPPORT_EMAIL,
        IT_SUPPORT_EMAIL
    );

    if (!$product) {
        wc_add_notice($error_contact_msg, 'error', ['product_id' => $product_id]);
        wp_send_json([
            'error' => true,
            'product_url' => $product_url
        ]);

        return;
    }

    $type = $product->get_type();

    if (('variable' === $type && $variation_id === 0)
        || 'variable' !== $type && $variation_id !== 0) {
        wc_add_notice($error_contact_msg, 'error', ['product_id' => $product_id]);
        wp_send_json([
            'error' => true,
            'product_url' => $product_url
        ]);

        return;
    }

    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount(wp_unslash($_POST['quantity']));

    $variation = [];
    if ('variable' === $type) {
        foreach ($product->get_variation_attributes() as $name => $values) {
            $attribute_key = 'attribute_' . sanitize_title($name);

            foreach ($attributes as $attribute) {
                if ($attribute['name'] === $attribute_key && in_array($attribute['value'], $values)) {
                    $variation[$attribute_key] = $attribute['value'];
                    break;
                }
            }
        }
    }

    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    $product_status = get_post_status($product_id);

    if ($passed_validation && false !== WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation) && 'publish' === $product_status) {
        do_action('woocommerce_ajax_added_to_cart', $product_id);

        // TODO Remove or reuse
        /**
         * if ('yes' === get_option('ql_woocommerce_cart_redirect_after_add')) {
         * wc_add_to_cart_message(array($product_id => $quantity), true);
         * }
         */
        WC_AJAX:: get_refreshed_fragments();
    } else {
        wp_send_json([
            'error' => true,
            'product_url' => $product_url
        ]);
    }
}
