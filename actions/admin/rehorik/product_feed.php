<?php
add_action('wp_ajax_activate_product_feeds', function () {
    try {
        Reh_Product_Feed::activate();
        wp_send_json_success(['refresh' => true]);
    } catch (Exception $e) {
        wp_send_json_error($e->getMessage());
    }
});

add_action('wp_ajax_deactivate_product_feeds', function () {
    try {
        Reh_Product_Feed::deactivate();
        wp_send_json_success(['refresh' => true]);
    } catch (Exception $e) {
        wp_send_json_error($e->getMessage());
    }
});
