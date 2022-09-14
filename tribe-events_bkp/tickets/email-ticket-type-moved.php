<?php
/**
 * This template is used for emails informing users of a change in ticket type
 * (where it has been moved from one post to another).
 *
 * Override this template in your own theme by creating a file at:
 *
 *     [your-theme]/tribe-events/tickets/email-ticket-type-moved.php
 *
 * @var int $original_event_id
 * @var string $original_event_name
 * @var int $new_event_id
 * @var string $new_event_name
 * @var int $ticket_type_id
 * @var string $ticket_type_name
 * @var int $num_tickets
 *
 * @version 4.5.1
 */

wc_get_template('emails/email-header.php', ['email_heading' => "Deine Karten"]);
?>
<?php
/**
 * Fires before the main content is rendered, within the
 * tickets/email-ticket-type-moved.php template.
 *
 * @param int $ticket_type_id
 */
do_action('tribe_tickets_moved_ticket_type_email_top', $ticket_type_id);
?>
    <h2><?php esc_html_e('Important changes to your tickets', 'event-tickets'); ?></h2>
    <p>
        <?php
        $message = _n(
            'We wanted to let you know that your ticket for %2$s has been transferred to %3$s%4$s. Your ticket remains valid and no further action is needed on your part.',
            'We wanted to let you know that your %1$s tickets for %2$s have been transferred to %3$s%4$s. Your existing tickets remain valid and no further action is needed on your part.',
            $num_tickets,
            'event-tickets'
        );

        $original_event = '<a href="' . esc_url(get_permalink($original_event_id)) . '">' . esc_html($original_event_name) . '</a>';
        $new_event = '<a href="' . esc_url(get_permalink($new_event_id)) . '">' . esc_html($new_event_name) . '</a>';

        $start_date = function_exists('tribe_get_start_date') ? tribe_get_start_date($new_event_id) : null;
        $new_event_date = '';

        if ($start_date) {
            $new_event_date = sprintf(__(' (taking place on %s)', 'event-tickets'), $start_date);
        }

        printf($message, $num_tickets, $original_event, $new_event, $new_event_date); ?>
    </p>

<?php
/**
 * Fires after the main content is rendered, within the
 * tickets/email-ticket-type-moved.php template.
 *
 * @param int $ticket_type_id
 */
do_action('tribe_tickets_moved_ticket_type_email_bottom', $ticket_type_id);
?>
<?php wc_get_template('emails/email-footer.php'); ?>