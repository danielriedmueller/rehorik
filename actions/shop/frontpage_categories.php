<?php
/**
 * Add coming next events to frontpage category pane
 */
add_action('woocommerce_after_subcategory', function (WP_Term $category) {
    if (!is_front_page()
        || !function_exists('tribe_get_events')
        || !class_exists(Tribe__Tickets__Tickets::class)
        || $category->slug !== TICKET_CATEGORY_SLUG) {
        return;
    }

    $events = tribe_get_events([
        'posts_per_page' => 6,
        'start_date' => 'now',
    ]);

    $html = '<div class="frontpage-category-action">';

    foreach ($events as $event) {
        /** @var WP_Post $event */
        $link = tribe_get_event_link($event->ID);

        $ticketsAvailable = true;
        $html .= sprintf(
            '<a class="%s" href="%s"><span>%s</span><span>%s</span></a>',
            $ticketsAvailable ? "" : "tickets-not-available",
            $link,
            date_i18n('d. M', strtotime($event->event_date)),
            $event->post_title
        );
    }
    $html .= '</div>';

    echo $html;
}, 10, 1);

/**
 * Add machine consultation appointment button to frontpage category pane
 */
add_action('woocommerce_after_subcategory', function (WP_Term $category) {
    if (!is_front_page() || $category->slug !== MACHINE_CATEGORY_SLUG) {
        return;
    }

    $html = '<div class="frontpage-category-action"><a class="button" target="_blank" href="https://app.resmio.com/rehorik-maschinenberatung/widget?backgroundColor=%235c0d2f&color=%23ceb67f&commentsDisabled=true&facebookLogin=false&&linkBackgroundColor=%23ceb67f&newsletterSignup=false">Jetzt Beratungstermin vereinbaren</a></div>';

    echo $html;
}, 10, 1);
