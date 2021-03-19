<?php
/**
 * Single Event Meta (Details) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @link http://m.tri.be/1aiy
 *
 * @package TribeEventsCalendar
 *
 * @version 4.6.19
 */


$event_id             = Tribe__Main::post_id_helper();
$time_format          = get_option( 'time_format', Tribe__Date_Utils::TIMEFORMAT );
$time_range_separator = tribe_get_option( 'timeRangeSeparator', ' - ' );
$show_time_zone       = tribe_get_option( 'tribe_events_timezones_show_zone', false );
$time_zone_label      = Tribe__Events__Timezones::get_event_timezone_abbr( $event_id );

$start_datetime = tribe_get_start_date();
$start_date = tribe_get_start_date( null, false );
$start_time = tribe_get_start_date( null, false, $time_format );
$start_ts = tribe_get_start_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );

$end_datetime = tribe_get_end_date();
$end_date = tribe_get_display_end_date( null, false );
$end_time = tribe_get_end_date( null, false, $time_format );
$end_ts = tribe_get_end_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );

$time_formatted = null;
if ( $start_time == $end_time ) {
	$time_formatted = esc_html( $start_time );
} else {
	$time_formatted = esc_html( $start_time . $time_range_separator . $end_time );
}

/**
 * Returns a formatted time for a single event
 *
 * @var string Formatted time string
 * @var int Event post id
 */
$time_formatted = apply_filters( 'tribe_events_single_event_time_formatted', $time_formatted, $event_id );

/**
 * Returns the title of the "Time" section of event details
 *
 * @var string Time title
 * @var int Event post id
 */
$time_title = apply_filters( 'tribe_events_single_event_time_title', __( 'Time:', 'the-events-calendar' ), $event_id );

$cost    = tribe_get_formatted_cost();
$website = tribe_get_event_website_link();
?>

<div class="rehorik-tribe-events-meta-details">
    <?php
    do_action( 'tribe_events_single_meta_details_section_start' );

    // All day (multiday) events
    if ( tribe_event_is_all_day() && tribe_event_is_multiday() ) :
        ?>
        <div><span><b>Datum</b></span><span><?php echo esc_html( $start_date ); ?> - <?php echo esc_html( $end_date ); ?></span></div>
    <?php
    // All day (single day) events
    elseif ( tribe_event_is_all_day() ):
        ?>
        <div><span><b>Datum</b></span><span><?php echo esc_html( $start_date ); ?></span></div>
    <?php
    // Multiday events
    elseif ( tribe_event_is_multiday() ) :
        ?>
        <div><span><b>Datum</b></span><span><?php echo esc_html( $start_datetime ); ?> - <?php echo esc_html( $end_datetime ); ?></span></div>
    <?php
    // Single day events
    else :
        ?>
        <div><span><b>Datum</b></span><span><?php echo esc_html( $start_date ); ?></span></div>
        <div><span><b>Uhrzeit</b></span><span><?php echo $time_formatted; ?></span></div>
    <?php endif ?>
</div>
