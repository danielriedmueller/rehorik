<?php
add_action('wp_ajax_rehorik_ajax_tribe_events_get_ticket_capacity', 'rehorik_tribe_events_get_ticket_capacity');
add_action('wp_ajax_nopriv_rehorik_ajax_tribe_events_get_ticket_capacity', 'rehorik_tribe_events_get_ticket_capacity');

function rehorik_tribe_events_get_ticket_capacity(): void
{
    $handleError = function () {
        wp_send_json(['error' => true], 404);
    };

    $ticketIds = $_POST['ticket_ids'];

    if (!is_array($ticketIds) || !wp_verify_nonce($_POST['nonce'], 'rehorik-tribe-events-ticket-capacity')) {
        $handleError();
        return;
    }

    $resultTexts = [];

    /** @var Tribe__Tickets__Tickets_Handler $tickets_handler */
    $tickets_handler = tribe( 'tickets.handler' );

    foreach ($ticketIds as $ticketId) {
        if (!is_numeric($ticketId)) {
            $handleError();
            return;
        }

        $availableTickets = $tickets_handler->get_ticket_max_purchase($ticketId);

        if ($availableTickets && $availableTickets > 0) {
            $resultTexts[$ticketId] = sprintf(
                'Noch <span>%s</span> %s verfügbar',
                $availableTickets,
                $availableTickets === 1 ? 'Platz' : 'Plätze'
            );
        } else {
            $resultTexts[$ticketId] = 'Nicht länger verfügbar';
        }
    }

    wp_send_json([
        'error' => false,
        'data' => $resultTexts
    ], 200);
}
