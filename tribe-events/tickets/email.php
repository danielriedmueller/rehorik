<?php
/**
 * Tickets Email Template
 * The template for the email with the purchased tickets when using ticketing plugins (Like WooTickets)
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/tickets/email.php
 *
 * This file is being included in events/lib/tickets/Tickets.php
 *  in the function generate_tickets_email_content. Each ticket provider class has a get_attendee() method returning an
 *  array with elements that have fields like this example for an RSVP type ticket:
 *    order_id => 10280
 *    purchaser_name => Person Example
 *    purchaser_email => person@example.com
 *    provider => Tribe__Tickets__RSVP
 *    provider_slug => rsvp
 *    purchase_time => 2020-10-26 17:59:18
 *    optout => 1
 *    ticket => Ticket Name
 *    attendee_id => 9280
 *    security => 122552ae
 *    product_id => 12322
 *    check_in =>
 *    order_status => yes
 *    order_status_label => Going
 *    user_id => 285
 *    ticket_sent =>
 *    event_id => 8872
 *    ticket_name => Ticket Name
 *    holder_name => Person Example
 *    holder_email => person@example.com
 *    ticket_id => ABC-XYZ-123
 *    qr_ticket_id => 12345
 *    security_code => abc123
 *    attendee_meta =>
 *    is_subscribed =>
 *    is_purchaser => 1
 *    ticket_exists => 1
 *
 * @link    https://evnt.is/1amp Help article for RSVP & Ticket template files.
 *
 * @since   4.0
 * @since   4.5.11 Ability to remove display of event date.
 * @since   4.7.4  Change event date to display by default.
 *               Display WooCommerce featured image.
 *               Current ticket action hook before output.
 * @since   4.7.6  Ability to filter ticket image.
 * @since   4.10.9 Use function for text.
 * @since   5.0.3 Update comments for single ticket array.
 * @since   5.1.7 Changed the word `Purchaser` to `Attendee` in the ticket details.
 *
 * @version 5.1.7
 *
 * @var array $tickets An array of tickets in the format documented above.
 */

wc_get_template('emails/email-header.php', ['email_heading' => "Deine Tickets"]);
?>

<?php
$count = 0;
$break = '';
foreach ($tickets as $ticket) {
    $count++;

    if ($count == 2) {
        $break = 'page-break-before:always !important;';
    }

    $event = get_post($ticket['event_id']);

    /** @var Tribe__Tickets__Tickets_Handler $handler */
    $handler = tribe('tickets.handler');

    $header_id = get_post_meta($ticket['event_id'], $handler->key_image_header, true);

    $header_img = false;

    /**
     * If the ticket is a WooCommerce product and has a featured image,
     * display it on email.
     *
     * @since 4.7.4
     */
    if ('Tribe__Tickets_Plus__Commerce__WooCommerce__Main' === $ticket['provider'] && class_exists('WC_Product')) {
        $product = new WC_Product($ticket['product_id']);
        $image_id = $product->get_image_id();
        if (!empty($image_id)) {
            $header_img = wp_get_attachment_image_src($image_id, 'full');
        }
    }

    if (!empty($header_id)) {
        $header_img = wp_get_attachment_image_src($header_id, 'full');
    }

    /**
     * Filters the ticket image that will be included in the tickets email
     *
     * @param bool|string $header_img False or header image src
     * @param int $header_id Parent post ticket header image ID if set
     * @param array $ticket Ticket information
     * @since 4.7.6
     *
     */
    $header_img = apply_filters('tribe_tickets_email_ticket_image', $header_img, $header_id, $ticket);

    $venue_label = '';
    $venue_name = null;

    if (function_exists('tribe_get_venue_id')) {
        $venue_id = tribe_get_venue_id($event->ID);
        if (!empty($venue_id)) {
            $venue = get_post($venue_id);
        }

        $venue_label = tribe_get_venue_label_singular();

        $venue_name = $venue_phone = $venue_address = $venue_city = $venue_web = '';
        if (!empty($venue)) {
            $venue_name = $venue->post_title;
            $venue_phone = get_post_meta($venue_id, '_VenuePhone', true);
            $venue_address = get_post_meta($venue_id, '_VenueAddress', true);
            $venue_city = get_post_meta($venue_id, '_VenueCity', true);
            $venue_state = get_post_meta($venue_id, '_VenueStateProvince', true);
            if (empty($venue_state)) {
                $venue_state = get_post_meta($venue_id, '_VenueState', true);
            }
            if (empty($venue_state)) {
                $venue_state = get_post_meta($venue_id, '_VenueProvince', true);
            }
            $venue_zip = get_post_meta($venue_id, '_VenueZip', true);
            $venue_web = get_post_meta($venue_id, '_VenueURL', true);
        }

        // $venue_address_style: make sure no double-quotes in the content
        $venue_address_style = "display:block; margin:0; font-family: 'Helvetica Neue', Helvetica, sans-serif; font-size:13px;";

        $venue_map_url = '';

        if (true === tribe_show_google_map_link($event->ID) && $venue_id) {
            $venue_map_url = esc_url(tribe_get_map_link($venue_id));
        }

        if (empty($venue_map_url)) {
            $venue_address_tag = 'span';
        } else {
            $venue_address_tag = 'a';
            $venue_address_style .= ' color:#006caa !important; text-decoration:underline;';
        }
    }

    $event_date = null;

    /**
     * Filters whether or not the event date should be included in the ticket email.
     *
     * @since 4.5.11
     * @since 4.7.4    Include event date default value changed to true
     *
     * @var bool Include event date? Defaults to true.
     * @var int  Event ID
     */
    $include_event_date = apply_filters('tribe_tickets_email_include_event_date', true, $event->ID);

    if ($include_event_date && function_exists('tribe_events_event_schedule_details')) {
        $event_date = tribe_events_event_schedule_details($event);
    }

    if (function_exists('tribe_get_organizer_ids')) {
        $organizers = tribe_get_organizer_ids($event->ID);
    }

    $event_link = function_exists('tribe_get_event_link') ? tribe_get_event_link($event->ID) : get_post_permalink($event->ID);

    ?>
    <div class="ticket">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
            <tr>
                <td valign="top" align="center" width="100%">
                    <h1>
                        <a href="<?php echo esc_url($event_link); ?>"><?php echo $event->post_title; ?></a>
                    </h1>
                    <?php if (!empty($event_date)) : ?>
                        <h4>
                            <span><?php echo $event_date; ?></span>
                        </h4>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
        <table class="ticket-details" border="0" cellpadding="0" cellspacing="0" width="590" align="center">
            <tr>
                <td valign="top" align="left" width="196">
                    <h3><?php esc_html_e('Ticket #', 'event-tickets'); ?></h3>
                    <span><?php echo $ticket['ticket_id']; ?></span>
                </td>
                <td valign="top" align="left" width="196">
                    <h3>Ticket-Typ</h3>
                    <span><?php echo $ticket['ticket_name']; ?></span>
                </td>
                <td valign="top" align="left" width="196">
                    <h3>Ticket-Käufer:in</h3>
                    <span><?php echo $ticket['holder_name']; ?></span>
                </td>
            </tr>
            <?php if ($venue_name || !empty($organizers)) : ?>
                <tr>
                    <?php if ($venue_name) : ?>
                        <td valign="top" align="left" width="196">
                            <h3><?php esc_html_e($venue_label, 'event-tickets'); ?></h3>
                            <span><?php echo $venue_name; ?></span>
                            <<?php echo $venue_address_tag; ?> <?php if ('a' === $venue_address_tag) {
                                printf('href="%s"', $venue_map_url);
                            } ?>>
                            <?php echo $venue_address; ?><br/>
                            <?php
                            if ($venue_city && ($venue_state || $venue_zip)) :
                                printf('%s, %s %s', $venue_city, $venue_state, $venue_zip);
                            else:
                                echo $venue_city;
                            endif;
                            ?>
                            </<?php echo $venue_address_tag; ?>>
                        </td>
                    <?php endif ?>
                    <?php if ($venue_phone) : ?>
                        <td valign="top" align="left" width="196">
                            <h3>Kontakt</h3>
                            <span><?php echo $venue_phone; ?></span>
                            <?php if (!empty($venue_web)): ?>
                                <a href="<?php echo esc_url($venue_web) ?>"><?php echo $venue_web; ?></a>
                            <?php endif ?>
                        </td>
                    <?php endif ?>
                    <?php if (!empty($organizers)) : ?>
                        <td valign="top" align="left" width="196">
                            <h3>Veranstalter:in</h3>
                            <?php foreach ($organizers as $organizer_id) { ?>
                                <div><?php echo tribe_get_organizer($organizer_id); ?></div>
                            <?php } ?>
                        </td>
                    <?php endif ?>
                </tr>
            <?php endif ?>
        </table>
        <?php
        /**
         * Allows inserting content after the "ticket details" section.
         *
         * @param array $ticket Ticket information.
         * @param WP_Post $event Event post object.
         * @since 4.12.3
         *
         */
        do_action('tribe_tickets_ticket_email_after_details', $ticket, $event);
        ?>
        <div class="qr-code">
            <table class="content" align="center" width="620" cellspacing="0" cellpadding="0" border="0" bgcolor="#CEB67F" style="margin:15px auto 0; padding:0;">
                <tr>
                    <td align="center" valign="top" class="wrapper" width="620">
                        <table class="inner-wrapper" border="0" cellpadding="0" cellspacing="0" width="620" bgcolor="#CEB67F" style="margin:0 auto !important; width:620px; padding:0;">
                            <tr>
                                <td valign="top" class="ticket-content" align="left" width="140" border="0" cellpadding="20" cellspacing="0" style="padding:20px; background:#CEB67F;">
                                    <?php do_action('tribe_tickets_ticket_email_ticket_bottom', $ticket); ?>
                                </td>
                                <td valign="top" class="ticket-content" align="left" border="0" cellpadding="20" cellspacing="0" style="padding:20px; background:#CEB67F;">
                                    <h3 style="color:#0a0a0e; margin:0 0 10px 0 !important; font-family: 'Helvetica Neue', Helvetica, sans-serif; font-style:normal; font-weight:700; font-size:28px; letter-spacing:normal; text-align:left;line-height: 100%;">
                                        <span style="color:#0a0a0e !important"><?php esc_html_e( 'Check in for this event', 'event-tickets-plus' ); ?></span>
                                    </h3>
                                    <p>
                                        <?php esc_html_e( 'Scan this QR code at the event to check in.', 'event-tickets-plus' ); ?>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <table class="ticket-security-code" border="0" cellpadding="0" cellspacing="0" width="590" align="right">
            <tr>
                <td valign="top" align="right"">
                    <span><?php esc_html_e('Security Code', 'event-tickets'); ?></span>
                    <span><?php echo $ticket['security_code']; ?></span>
                </td>
            </tr>
        </table>
    </div>
<?php }//end foreach ?>
<div id="ticket-bottom">
    <?php do_action('tribe_tickets_ticket_email_bottom'); ?>
</div>
<?php wc_get_template('emails/email-footer.php'); ?>
