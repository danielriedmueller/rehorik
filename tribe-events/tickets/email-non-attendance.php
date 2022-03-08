<?php
/**
 * Email used to notify someone that their RSVP was received.
 *
 * This email is used on those occasions where the user noted
 * that they would *not* be attending. You may override this
 * template in your own theme by creating a file at:
 *
 *     [your-theme]/tribe-events/tickets/email-non-attendance.php
 *
 * @var int $event_id
 * @var int $order_id
 * @var array $attendees
 *
 * @version 4.7.4
 */

$event_date = null;

/**
 * Filters whether or not the event date should be included in the ticket email.
 *
 * @param bool Include event date? Defaults to true.
 * @param int  Event ID
 * @since 4.7.4
 *
 */
$include_event_date = apply_filters('tribe_tickets_email_include_event_date', true, $event_id);

if ($include_event_date && function_exists('tribe_events_event_schedule_details')) {
    $event_date = tribe_events_event_schedule_details($event_id);
}

wc_get_template('emails/email-header.php', ['email_heading' => "Deine Karten"]);
?>
<?php
/**
 * Fires immediately before the main body of content within ticket emails
 * is rendered.
 */
do_action('tribe_tickets_ticket_email_top');
?>

<table class="content" align="center" width="590" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
    <tr>
        <td align="center" valign="top" class="wrapper" width="590">
            <h2>
                <span>
                    <?php echo esc_html(get_the_title($event_id)); ?>
                </span>
            </h2>
            <?php if (!empty($event_date)) : ?>
                <h4>
                    <span><?php echo $event_date; ?></span>
                </h4>
            <?php endif; ?>
            <p>
                <?php _e('Thank you for confirming that you will not be attending the above event.',
                    'event-tickets'); ?>
            </p>
            <p>
                <a href="<?php echo esc_url(get_permalink($event_id)); ?>"><?php echo esc_html(get_the_title($event_id)); ?></a>
                <a href="<?php echo esc_url(get_home_url()); ?>"><?php echo esc_html(get_bloginfo('name')); ?></a>
            </p>
        </td>
    </tr>
</table>

<?php
/**
 * Fires immediately after the main body of content within ticket emails
 * is rendered.
 */
do_action('tribe_tickets_ticket_email_bottom');
?>
<?php wc_get_template('emails/email-footer.php'); ?>

