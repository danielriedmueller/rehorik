<?php
/**
 * Add coming next events to frontpage category pane
 */
add_action('woocommerce_before_subcategory', function(WP_Term $category) {
    if ($category->slug !== TICKET_CATEGORY_SLUG){
        return;
    }

    $events = tribe_get_events([
        'posts_per_page' => 5,
        'start_date'     => 'now',
    ]);

    $html = '<div class="rehorik-upcoming-events"><table>';
    foreach ($events as $event) {
        /** @var WP_Post $event */
        $html .= sprintf('<tr><td>%s</td><td>%s</td></tr>', $event->post_title, $event->event_date);
    }

    $html .= '</table></div>';

    echo $html;
}, 10, 1);
