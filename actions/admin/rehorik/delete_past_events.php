<?php
add_action('wp_ajax_hide_past_event_tickets', function () {
    try {
        $updateStock = function($product) {
            /** @var WC_Product $product */
            $product->set_stock_quantity(0);
            $product->set_stock_status('outofstock');
            $product->save();
        };

        $message = '';

        foreach (wc_get_products([
            'category' => [TICKET_CATEGORY_SLUG],
            'limit' => -1,
        ]) as $product) {
            if ($product->is_in_stock()) {
                $event = tribe_events_get_ticket_event($product->get_id());
                if (!$event) {
                    $message .= sprintf('no event: <a href="%s">%s</a><br>', $product->get_permalink(), $product->get_title());
                    $updateStock($product);
                } else if ($event->post_status === 'trash') {
                    $message .= sprintf('trashed event: <a href="%s">%s</a><br>', $product->get_permalink(), $product->get_title());
                    $updateStock($product);
                } else if (tribe_is_past_event($event)) {
                    $message .= sprintf('past event: <a href="%s">%s</a><br>', $product->get_permalink(), $product->get_title());
                    $updateStock($product);
                }
            }
        }

        wp_send_json_success(['message' => $message]);
    } catch (Exception $e) {
        wp_send_json_error($e->getMessage());
    }
});
