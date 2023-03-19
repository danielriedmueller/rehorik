<?php
add_action('wp_ajax_rehorik_ajax_tribe_events_get_ticket_capacity', 'rehorik_tribe_events_get_ticket_capacity');
add_action('wp_ajax_nopriv_rehorik_ajax_tribe_events_get_ticket_capacity', 'rehorik_tribe_events_get_ticket_capacity');

function rehorik_tribe_events_get_ticket_capacity(): void
{
    $ticket_id = absint($_POST['ticket_id']);

    $event = tribe_events_get_ticket_event($ticket_id);

    if (!$event || !wp_verify_nonce($_POST['nonce'], 'rehorik-tribe-events-ticket-capacity')) {
        wp_send_json(['error' => true], 404);
        return;
    }

    $availableTickets = null;
    $tickets = Tribe__Tickets__Tickets::get_all_event_tickets($event->ID);
    if (!empty($tickets)) {
        foreach ($tickets as $ticket) {
            if ($ticket->ID === $ticket_id) {
                $availableTickets = $ticket->available();
            }
        }
    }

    if ($availableTickets && $availableTickets > 0) {
        wp_send_json([
            'error' => false,
            'text' => sprintf(
                'Noch <span>%s</span> %s verfügbar',
                $availableTickets,
                $availableTickets === 1 ? 'Platz' : 'Plätze'
            )
        ], 200);
    } else {
        wp_send_json([
            'error' => false,
            'text' => 'Nicht länger verfügbar',
        ], 200);
    }
}
