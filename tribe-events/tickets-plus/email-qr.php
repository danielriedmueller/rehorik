<?php
/**
 * QR code insert in tickets email
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe/tickets-plus/email-qr.php
 *
 * @link    https://evnt.is/1amp See more documentation about our views templating system.
 *
 * @since 4.7.6
 * @since 5.1.0 Updated template link.
 *
 * @version 5.1.0
 *
 */

if (!defined('ABSPATH')) {
    die('-1');
}
?>
<img id="ticket-qr-code" src="<?php echo esc_url($qr); ?>" width="140" height="140" alt="QR Code Image"/>
