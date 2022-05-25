<?php
/**
 * Add ticket category to created ticket products
 * and set product_type to simple instead of virtual
 * and add event date as date on sale to
 */
add_action('event_tickets_after_save_ticket', function ($event_id, $ticket, $raw_data, $classname) {
    if (!empty($ticket) && isset($ticket->ID)) {
        $eventCatId = get_term_by('slug', TICKET_CATEGORY_SLUG, 'product_cat' )->term_id;
        $categoryIds = array_unique(array_filter(array_map(function ($a) {
            $productCat = get_term_by('slug', $a->slug, 'product_cat');
            if ($productCat) {
                return $productCat->term_id;
            }

            return null;
        }, get_the_terms($event_id, 'tribe_events_cat'))));

        $product = wc_get_product($ticket->ID);

        $thumbnailId = get_post_thumbnail_id($event_id);
        if ($thumbnailId) {
            set_post_thumbnail($ticket->ID, $thumbnailId);
        }

        $startDatetime = explode(" ", tribe_get_start_date($event_id, true, 'd.m.Y H:i'));
        $endDatetime = explode(" ", tribe_get_end_date($event_id, true, 'd.m.Y H:i'));
        update_post_meta($product->get_id(), TICKET_EVENT_DATE_START_META, $startDatetime[0] ?? "");
        update_post_meta($product->get_id(), TICKET_EVENT_DATE_END_META, $endDatetime[0] ?? "");
        update_post_meta($product->get_id(), TICKET_EVENT_TIME_START_META, $startDatetime[1] ?? "");
        update_post_meta($product->get_id(), TICKET_EVENT_TIME_END_META, $endDatetime[1] ?? "");

        $product->set_category_ids(array_merge([$eventCatId], $categoryIds));
        $product->set_catalog_visibility('visible');
        $product->save();
    }
}, 10, 4);