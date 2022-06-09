<?php
add_action('wp_ajax_hide_past_event_tickets', function () {
    try {
        $updateStock = function($product) {
            /** @var WC_Product $product */
            $product->set_stock_quantity(0);
            $product->set_stock_status('outofstock');
            $product->save();
        };

        foreach (wc_get_products([
            'category' => [TICKET_CATEGORY_SLUG],
            'limit' => -1,
        ]) as $product) {
            if ($product->is_in_stock()) {
                $event = tribe_events_get_ticket_event($product->get_id());
                if (!$event) {
                    echo sprintf('no event: <a href="%s">%s</a><br>', $product->get_permalink(), $product->get_title());
                    $updateStock($product);
                } else if (tribe_is_past_event($event)) {
                    echo sprintf('past event: <a href="%s">%s</a><br>', $product->get_permalink(), $product->get_title());
                    $updateStock($product);
                }
            }
        }
    } catch (Exception $exception) {
        echo "error: " . $exception->getMessage();
    }
});

/**
 * TODO: Remove dead code
 */
add_action('wp_ajax_update_tickets_date', function () {
    try {
        foreach (wc_get_products([
            'category' => [TICKET_CATEGORY_SLUG],
            'limit' => -1,
        ]) as $product) {
            /** @var WC_Product $product */
            $event = tribe_events_get_ticket_event($product->get_id());

            $startDatetime = explode(" ", tribe_get_start_date($event->ID, true, 'Y-m-d H:i'));
            $endDatetime = explode(" ", tribe_get_end_date($event->ID, true, 'Y-m-d H:i'));
            update_post_meta($product->get_id(), TICKET_EVENT_DATE_START_META, $startDatetime[0] ?? "");
            update_post_meta($product->get_id(), TICKET_EVENT_DATE_END_META, $endDatetime[0] ?? "");
            update_post_meta($product->get_id(), TICKET_EVENT_TIME_START_META, $startDatetime[1] ?? "");
            update_post_meta($product->get_id(), TICKET_EVENT_TIME_END_META, $endDatetime[1] ?? "");

            echo sprintf(
                '%s: %s %s - %s %s <br>',
                $product->get_title(),
                $product->get_meta(TICKET_EVENT_DATE_START_META),
                $product->get_meta(TICKET_EVENT_TIME_START_META),
                $product->get_meta(TICKET_EVENT_DATE_END_META),
                $product->get_meta(TICKET_EVENT_TIME_END_META),
            );
        }
    } catch (Exception $exception) {
        echo "error: " . $exception->getMessage();
    }
});

/**
 * TODO: Remove dead code
 *
 * Method to delete Woo Product
 *
 * @param int $id the product ID.
 * @param bool $force true to permanently delete product, false to move to trash.
 * @throws Exception
 */
function wh_deleteProduct($id, $force = false): bool {
    $product = wc_get_product($id);

    if (empty($product)) {
        throw new Exception(999, sprintf(__('No %s is associated with #%d', 'woocommerce'), 'product', $id));
    }

    // If we're forcing, then delete permanently.
    if ($force) {
        if ($product->is_type('variable')) {
            foreach ($product->get_children() as $child_id) {
                $child = wc_get_product($child_id);
                $child->delete(true);
            }
        } elseif ($product->is_type('grouped')) {
            foreach ($product->get_children() as $child_id) {
                $child = wc_get_product($child_id);
                $child->set_parent_id(0);
                $child->save();
            }
        }

        $product->delete(true);
        $result = $product->get_id() > 0 ? false : true;
    } else {
        $product->delete();
        $result = 'trash' === $product->get_status();
    }

    if (!$result) {
        throw new Exception(999, sprintf(__('This %s cannot be deleted', 'woocommerce'), 'product'));
    }

    // Delete parent product transients.
    if ($parent_id = wp_get_post_parent_id($id)) {
        wc_delete_product_transients($parent_id);
    }

    return true;
}
