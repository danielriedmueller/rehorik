<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

require_once(get_stylesheet_directory() . '/helper/product_attributes_helper.php');

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

$event_id = get_the_ID();
$isOnline = isEventOnline($event_id);
$isCanceled = get_post_meta($event_id, CANCELED_META_KEY);
get_template_part('templates/tribe-events-attendee-list');
?>

<div id="tribe-events-content" class="rehorik-tribe-events-single tribe-events-single <?= $isOnline ? "event-online" : "" ?> <?= $isCanceled ? "event-canceled" : "" ?>">
	<!-- Notices -->
	<?php tribe_the_notices() ?>

	<?php the_title( '<h1 class="tribe-events-single-event-title">', '</h1>' ); ?>

	<div class="tribe-events-schedule tribe-clearfix">
		<?php echo tribe_events_event_schedule_details( $event_id, '<h2>', '</h2>' ); ?>
		<?php if ( tribe_get_cost() ) : ?>
			<span class="tribe-events-cost"><?php echo tribe_get_cost( null, true ) ?></span>
		<?php endif; ?>
	</div>

	<?php while ( have_posts() ) :  the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('rehorik-tribe-events-single-event-content'); ?>>
			<!-- Event featured image, but exclude link -->
            <div>
                <!-- Event content -->
                <?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
                <?php echo tribe_event_featured_image( $event_id, 'full', false ); ?>
                <div class="rehorik-tribe-events-single-description">
                    <?php the_content(); ?>
                </div>
            </div>
            <div>
                <!-- .tribe-events-single-event-description -->
                <?php tribe_get_template_part( 'modules/meta' ); ?>
                <?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
                <!-- Calendar links -->
                <?php do_action( 'tribe_events_single_event_after_the_content' ) ?>
                <?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
            </div>
		</div> <!-- #post-x -->
		<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
	<?php endwhile; ?>

    <div class="rehorik-tribe-events-single-event-info-outer">
        <h2>Informationen zur Veranstaltung</h2>
        <div class="rehorik-tribe-events-single-event-info">
            <div>
                <p><b>VERANSTALTER:</b> Rehorik Rösterei & Feinkost GmbH</p>
                <p><b>TELEFON:</b> <a href="tel:<?= CONTACT_PHONE ?>"><?= CONTACT_PHONE ?></a></p>
                <p><b>E-MAIL:</b> <a href="mailto:events@rehorik.de">events@rehorik.de</a></p>
            </div>
            <div>
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/veranstaltungen/thumbnail_website-events-600px.jpg" alt="Rehorik Event Information Bild">
            </div>
        </div>
    </div>
</div><!-- #tribe-events-content -->
