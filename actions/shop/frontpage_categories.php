<?php
/**
 * Add coming next events to frontpage category pane
 */
add_action('woocommerce_after_subcategory', function(WP_Term $category) {
    if (!is_front_page()
        || !function_exists('tribe_get_events')
        || !class_exists(Tribe__Tickets__Tickets::class)
        || $category->slug !== TICKET_CATEGORY_SLUG) {
        return;
    }

    $events = tribe_get_events([
        'posts_per_page' => 6,
        'start_date'     => 'now',
    ]);

    $html = '<div class="rehorik-upcoming-events">';

    foreach ($events as $event) {
        /** @var WP_Post $event */
        $link = tribe_get_event_link($event->ID);
        //$event->get( 'is_sale_past' );
        $tickets = Tribe__Tickets__Tickets::get_all_event_tickets( $event->ID );

        $ticketsAvailable = false;
        foreach ($tickets as $ticket) {
            /** @var  Tribe__Tickets__Ticket_Object $ticket */
            $available = $ticket->available();
            $dateInRange = $ticket->date_in_range('now');

            if ($available && $dateInRange) {
                $ticketsAvailable = true;
                break;
            }
        }

        $html .= sprintf(
            '<a class="%s" href="%s"><span>%s</span><span>%s</span></a>',
            $ticketsAvailable ? "" : "tickets-not-available",
            $link,
            date_i18n('d. M', strtotime($event->event_date)),
            $event->post_title
        );
    }
    $html .= '</div>';

    echo $html;
}, 10, 1);
