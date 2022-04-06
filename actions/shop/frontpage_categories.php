<?php
/**
 * Add coming next events to frontpage category pane
 */
add_action('woocommerce_after_subcategory', function(WP_Term $category) {
    if ($category->slug !== TICKET_CATEGORY_SLUG){
        return;
    }

    $events = tribe_get_events([
        'posts_per_page' => 4,
        'start_date'     => 'now',
    ]);

    $html = '<div class="rehorik-upcoming-events">';
    foreach ($events as $event) {
        /** @var WP_Post $event */
        $link = tribe_get_event_link($event->ID);
        $html .= sprintf(
            '<a href="%s"><span>%s</span><span>%s</span></a>',
            $link,
            date('d. M', strtotime($event->event_date)),
            $event->post_title
        );
    }
    $html .= '</div>';

    echo $html;
}, 10, 1);
