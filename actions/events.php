<?php
/**
 * Add ticket category to created ticket products
 * and set product_type to simple instead of virtual
 * and add event date as date on sale to
 */
add_action('event_tickets_after_save_ticket', function ($event_id, $ticket, $raw_data, $classname) {
    if (!empty($ticket) && isset($ticket->ID)) {
        $product = wc_get_product($ticket->ID);

        $thumbnailId = get_post_thumbnail_id($event_id);
        if ($thumbnailId) {
            set_post_thumbnail($ticket->ID, $thumbnailId);
        }

        setEventDate($product, $event_id);
        considerVisibility($product, $event_id);
        setCategories($product, $event_id);

        $product->save();
    }
}, 10, 4);

add_action('save_post_tribe_events', function ($postId) {
    $tickets = Tribe__Tickets__Tickets::get_event_tickets($postId);
    if ($tickets && is_array($tickets)) {
        foreach ($tickets as $ticket) {
            $product = wc_get_product($ticket->ID);
            setCategories($product, $postId);
            $product->save();
        }
    }
});

/**
 * If there is already an visible ticket, set not visible
 *
 * @return void
 */
function considerVisibility($product, $eventId): void {
    if ($product->get_catalog_visibility() === 'visible') {
        return;
    }

    $needToBeVisible = true;

    $tickets = Tribe__Tickets__Tickets::get_event_tickets($eventId);
    if ($tickets && is_array($tickets)) {
        foreach ($tickets as $ticket) {
            /** @var Tribe__Tickets__Ticket_Object $ticket */
            $ticketProduct = wc_get_product($ticket->ID);
            $visibility = $ticketProduct->get_catalog_visibility();

            if ($visibility === 'visible') {
                $needToBeVisible = false;
            }
        }
    }

    if ($needToBeVisible) {
        $product->set_catalog_visibility('visible');
    }
}

function setCategories($product, $eventId): void {
    $catTerms = get_the_terms($eventId, 'tribe_events_cat');

    if ($catTerms) {
        $eventCatId = get_term_by('slug', TICKET_CATEGORY_SLUG, 'product_cat' )->term_id;
        $categoryIds = array_unique(array_filter(array_map(function ($a) {
            $productCat = get_term_by('slug', $a->slug, 'product_cat');
            if ($productCat) {
                return $productCat->term_id;
            }

            return null;
        }, $catTerms)));

        $product->set_category_ids(array_merge([$eventCatId], $categoryIds));
    }
}

/**
 * Add event date as meta information
 *
 * @param $product
 * @param $eventId
 * @return void
 */
function setEventDate($product, $eventId): void {
    $startDatetime = strtotime(tribe_get_start_date($eventId, true, 'd.m.Y H:i'));
    $endDatetime = strtotime(tribe_get_end_date($eventId, true, 'd.m.Y H:i'));

    if ($startDatetime) {
        update_post_meta($product->get_id(), TICKET_EVENT_DATE_START_META, $startDatetime);
    }

    if ($endDatetime) {
        update_post_meta($product->get_id(), TICKET_EVENT_DATE_END_META, $endDatetime);
    }
}