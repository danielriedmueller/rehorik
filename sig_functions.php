<?php
/*
 * EXAMPLE OF CHANGING ANY TEXT (STRING) IN THE EVENTS CALENDAR
 * See the codex to learn more about WP text domains:
 * http://codex.wordpress.org/Translating_WordPress#Localization_Technology
 * Example Tribe domains: 'tribe-events-calendar', 'tribe-events-calendar-pro'...
 */
function tribe_custom_theme_text ( $translation, $text, $domain ) {

    // Put your custom text here in a key => value pair
    // Example: 'Text you want to change' => 'This is what it will be changed to'
    // The text you want to change is the key, and it is case-sensitive
    // The text you want to change it to is the value
    // You can freely add or remove key => values, but make sure to separate them with a comma
    // This example changes the label "Venue" to "Location", and "Related Events" to "Similar Events"
    $custom_text = array(
        'Eintritt:' => 'Kosten:',
    );

    // If this text domain starts with "tribe-", "the-events-", or "event-" and we have replacement text
    if( (strpos($domain, 'tribe-') === 0 || strpos($domain, 'the-events-') === 0 || strpos($domain, 'event-') === 0) && array_key_exists($translation, $custom_text) ) {
        $translation = $custom_text[$translation];
    }
    return $translation;
}
add_filter('gettext', 'tribe_custom_theme_text', 20, 3);

?>