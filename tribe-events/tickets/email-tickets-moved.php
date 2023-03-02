<?php
/**
 * This template is used for emails informing users of a change in tickets
 * (where they have been reassigned to another ticket type and/or to another
 * event entirely.
 *
 * Override this template in your own theme by creating a file at:
 *
 *     [your-theme]/tribe-events/tickets/email-tickets-moved.php
 *
 * @var int $original_event_id
 * @var string $original_event_name
 * @var int $new_event_id
 * @var string $new_event_name
 * @var int $ticket_type_id
 * @var string $ticket_type_name
 * @var array $affected_tickets
 *
 * @version 4.5.1
 */

wc_get_template('emails/email-header.php', ['email_heading' => "Deine Tickets"]);
?>
<?php
/**
 * Fires before the main content is rendered, within the
 * tickets/email-tickets-moved.php template.
 *
 * @param int $ticket_type_id
 */
do_action('tribe_tickets_moved_tickets_email_top', $ticket_type_id);
?>
    <h2><?php esc_html_e('Important changes to your tickets', 'event-tickets'); ?></h2>
    <p>
        <?php
        $message = _n(
            'We wanted to let you know that a ticket you purchased for %2$s has been transferred to %3$s%4$s. Your ticket remains valid and no further action is needed on your part:',
            'We wanted to let you know that the following %1$s tickets for %2$s have been transferred to %3$s%4$s. Your existing tickets remain valid and no further action is needed on your part:',
            count($affected_tickets),
            'event-tickets'
        );

        $original_event = '<a href="' . esc_url(get_permalink($original_event_id)) . '">' . esc_html($original_event_name) . '</a>';
        $new_event = '<a href="' . esc_url(get_permalink($new_event_id)) . '">' . esc_html($new_event_name) . '</a>';

        $start_date = tribe_get_start_date($new_event_id);
        $new_event_date = '';

        if ($start_date) {
            $new_event_date = sprintf(__(' (taking place on %s)', 'event-tickets'), $start_date);
        }

        printf($message, count($affected_tickets), $original_event, $new_event, $new_event_date); ?>
    </p>

    <ul> <?php foreach ($affected_tickets as $attendee): ?>
            <li>
                <tt> #<?php echo esc_html($attendee['attendee_id']); ?> </tt>
                <strong> <?php echo esc_html($attendee['ticket']); ?> </strong>
                &ndash; <?php echo esc_html($attendee['security']); ?>
            </li>
        <?php endforeach; ?> </ul>

<?php
/**
 * Fires after the main content is rendered, within the
 * tickets/email-tickets-moved.php template.
 *
 * @param int $ticket_type_id
 */
do_action('tribe_tickets_moved_ticket_email_bottom', $ticket_type_id);
?>
<?php wc_get_template('emails/email-footer.php'); ?>
