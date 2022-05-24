<?php

add_action('wp_ajax_delete_past_events', function () {
    try {
        foreach (wc_get_products([
            'category' => [TICKET_CATEGORY_SLUG],
            'limit' => -1,
        ]) as $product) {
            /** @var WC_Product $product */
            $event = tribe_events_get_ticket_event($product->get_id());
            if (!$event) {
                echo $product->get_title() . '<br>';
                wh_deleteProduct($product->get_id());
            }
        }
    } catch (Exception $exception) {
        echo "error: " . $exception->getMessage();
    }

});

/**
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
