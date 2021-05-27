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
 * and set product_type to simple instead of virtual
 */
add_action('event_tickets_after_save_ticket', function ($event_id, $ticket, $raw_data, $classname) {
    if (!empty($ticket) && isset($ticket->ID)) {
        $cat = get_term_by( 'slug', TICKET_CATEGORY_SLUG, 'product_cat' );
        $product = wc_get_product( $ticket->ID );

        $thumbnailId = get_post_thumbnail_id($event_id);
        if ($thumbnailId) {
            set_post_thumbnail($ticket->ID, $thumbnailId);
        }

        $product->set_category_ids([$cat->term_id]);
        $product->set_catalog_visibility('visible');
        $product->save();
    }
}, 10, 4);

function rehorik_single_product_attributes(  ) {
    echo get_template_part('templates/product-single-attributes');
};
add_action( 'woocommerce_single_product_summary', 'rehorik_single_product_attributes', 15, 0 );


remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_product_additional_information', 'woocommerce_template_single_excerpt', 50 );