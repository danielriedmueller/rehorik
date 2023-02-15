<?php
add_action('wp_ajax_activate_product_feeds', function () {
    try {
        Reh_Product_Feed::schedule_event();
        wp_send_json_success(['refresh' => true]);
    } catch (Exception $e) {
        wp_send_json_error($e->getMessage());
    }
});

add_action('wp_ajax_deactivate_product_feeds', function () {
    try {
        Reh_Product_Feed::clear_schedule();
        wp_send_json_success(['refresh' => true]);
    } catch (Exception $e) {
        wp_send_json_error($e->getMessage());
    }
});

add_action('wp_ajax_create_product_feeds', function () {
    try {
        $productFeed = Reh_Product_Feed::instance();
        $productFeed->updateFeed();
        wp_send_json_success(['refresh' => true]);
    } catch (Exception $e) {
        wp_send_json_error($e->getMessage());
    }
});
