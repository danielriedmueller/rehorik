<?php
/**
 * Single Event Meta (Venue) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/venue.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 */

if ( ! tribe_get_venue_id() ) {
	return;
}

$phone   = tribe_get_phone();
$website = tribe_get_venue_website_link();

?>

<div class="rehorik-tribe-events-meta-venue">
    <div><span><b>Ort</b></span><span><?php echo tribe_get_venue(); ?></span></div>
    <?php if ( tribe_address_exists() ) : ?>
        <div><span><b>Adresse</b></span><span><?php echo tribe_get_full_address(); ?></span></div>
        <?php if ( tribe_show_google_map_link() ) : ?>
            <?php echo tribe_get_map_link_html(); ?>
        <?php endif; ?>
    <?php endif; ?>
</div>
