<?php
add_action('wp_ajax_rehorik_ajax_add_to_cart', 'rehorik_add_to_cart');
add_action('wp_ajax_nopriv_rehorik_ajax_add_to_cart', 'rehorik_add_to_cart');
add_action('wp_ajax_rehorik_ajax_update_cart', 'rehorik_update_cart');
add_action('wp_ajax_nopriv_rehorik_ajax_update_cart', 'rehorik_update_cart');
add_action('wp_ajax_rehorik_ajax_select_shipping_method', 'rehorik_select_shipping_method');
add_action('wp_ajax_nopriv_rehorik_ajax_select_shipping_method', 'rehorik_select_shipping_method');

function rehorik_select_shipping_method(): void
{
    $shipping_method = $_POST['shipping_method'];

     if (!check_ajax_referer('reh-nonce', 'nonce', false)) {
        handle_error($_SERVER['HTTP_REFERER'], "Invalid nonce");
        return;
    }

    WC()->session->set( 'chosen_shipping_methods', [$shipping_method] );
    WC()->cart->calculate_totals();
    WC_AJAX::get_refreshed_fragments();
}

function rehorik_add_to_cart(): void
{
    $product_id = absint($_POST['product_id']);
    $variation_id = absint($_POST['variation_id']);
    $product = wc_get_product($product_id);
    $product_url = apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id);

    if (!check_ajax_referer('reh-nonce', 'nonce', false)) {
        handle_error($product_url, 'Invalid nonce');
        return;
    }

    if (!$product) {
        handle_error($product_url, "Product $product_id not found");
        return;
    }

    $type = $product->get_type();

    if (('variable' === $type && $variation_id === 0)
        || 'variable' !== $type && $variation_id !== 0) {
        handle_error($product_url, "Variation $variation_id not found");
        return;
    }

    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount(wp_unslash($_POST['quantity']));

    $variation = [];
    if ('variable' === $type) {
        foreach ($product->get_variation_attributes() as $name => $values) {
            $attribute_key = 'attribute_' . sanitize_title($name);
            $attributes = $_POST['attributes'] ?? [];

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

    if ($passed_validation && false !== WC()->cart->add_to_cart($product_id, $quantity, $variation_id,
            $variation) && 'publish' === $product_status) {
        do_action('woocommerce_ajax_added_to_cart', $product_id);
        WC_AJAX::get_refreshed_fragments();
    } else {
        handle_error($product_url, "Product $product_id could not be added to cart");
    }
}

function rehorik_update_cart(): void
{
    $key = sanitize_text_field($_POST['cart_item_key']);
    $value = intval(sanitize_text_field($_POST['cart_item_value']));

    if (!check_ajax_referer('reh-nonce', 'nonce', false)) {
        handle_error($_SERVER['HTTP_REFERER'], "Invalid nonce");
        return;
    }

    if (!$key || $value < 0 || !WC()->cart->get_cart_item($key)) {
        handle_error($_SERVER['HTTP_REFERER'], "Cart item $key, $value not found");
        return;
    }

    WC()->cart->set_quantity($key, $value);
    WC_AJAX::get_refreshed_fragments();
}

function handle_error($redirectUrl, $message): void
{
    $error_contact_msg = sprintf(
        'Hoppla, hier gibts ein technisches Problem. Bitte schreibe uns eine Mail an <a href="%s">%s</a> und wir schauen uns die Sache an oder probiere es einfach später nochmal.',
        IT_SUPPORT_EMAIL,
        IT_SUPPORT_EMAIL
    );
    error_log(date('Y-m-d-H-i-s') . ': ' . $message . PHP_EOL, 3, get_stylesheet_directory() . '/reh-debug.log');
    wc_add_notice($error_contact_msg, 'error');
    wp_send_json([
        'error' => true,
        'redirect_url' => $redirectUrl,
    ]);
}
