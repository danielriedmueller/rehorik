<?php

function hide_past_events_tickets() {
    foreach (wc_get_products([
        'category' => [TICKET_CATEGORY_SLUG]
    ]) as $product) {
        /** @var WC_Product $product */
        $event = tribe_events_get_ticket_event($product->get_id());
        if($event) {
            if (tribe_is_past_event($event)) {
                $product->set_catalog_visibility('hidden');
                $product->save();
            }
        }
    }
}
add_action('rh_past_events_cron_hook', 'hide_past_events_tickets');

