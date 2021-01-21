<?php
/**
 * Adds page title to the top on woocommerce pages
 */
add_action('et_before_main_content', function () {
    if (is_woocommerce() || is_cart() || is_checkout()) {
        echo get_template_part('templates/page-title');
    }
});

/**
 * Removes breadcrumb.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

/**
 * Add ticket category to created ticket products
 */
add_action('event_tickets_after_save_ticket', function ($event_id, $ticket, $raw_data, $classname) {
    if (!empty($ticket) && isset($ticket->ID)) {
        wp_add_object_terms($ticket->ID, TICKET_CATEGORY_SLUG, 'product_cat');
    }
}, 10, 4);