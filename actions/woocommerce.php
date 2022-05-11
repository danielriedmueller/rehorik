<?php
require_once('admin/add_cat_video_field.php');
require_once('admin/add_product_preperation_recommendation_field.php');
require_once('admin/add_product_video_field.php');
require_once('shop/frontpage_categories.php');

add_action( 'after_setup_theme', function() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
});

/**
 * Removes breadcrumb.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

/**
 * For offline event tickets sale.
 * Only company user accounts are allowed to buy tickets by cheque
 * In this case, set order to complete.
 */
add_action('woocommerce_thankyou', function ($order_id) {
    if (!$order_id) {
        return;
    }

    $order = new WC_Order($order_id);
    if (!$order) {
        return;
    }

    // Only paying cash, set order status
    if ($order->get_payment_method() !== PAYMENT_METHOD_CASH) {
        return;
    }

    $items = $order->get_items();

    $updateOrderStatus = false;
    foreach ($items as $item) {
        $product = $item->get_product();

        if ($product) {
            /**
             * @var WC_Product $product
             */
            $eventCatId = get_term_by('slug', TICKET_CATEGORY_SLUG, 'product_cat' )->term_id;
            if ($product->is_virtual() && in_array($eventCatId, $product->get_category_ids())) {
                $updateOrderStatus = true;
            }
        }
    }

    if ($updateOrderStatus) {
        $order->update_status( 'completed' );
    }
}, 10, 1);

/**
 * Add ticket category to created ticket products
 * and set product_type to simple instead of virtual
 */
add_action('event_tickets_after_save_ticket', function ($event_id, $ticket, $raw_data, $classname) {
    if (!empty($ticket) && isset($ticket->ID)) {
        $eventCatId = get_term_by('slug', TICKET_CATEGORY_SLUG, 'product_cat' )->term_id;
        $categoryIds = array_unique(array_filter(array_map(function ($a) {
            $productCat = get_term_by('slug', $a->slug, 'product_cat');
            if ($productCat) {
                return $productCat->term_id;
            }

            return null;
        }, get_the_terms($event_id, 'tribe_events_cat'))));

        $product = wc_get_product($ticket->ID);

        $thumbnailId = get_post_thumbnail_id($event_id);
        if ($thumbnailId) {
            set_post_thumbnail($ticket->ID, $thumbnailId);
        }

        $product->set_category_ids(array_merge([$eventCatId], $categoryIds));
        $product->set_catalog_visibility('visible');
        $product->save();
    }
}, 10, 4);

// Add delete account feature
add_action( 'woocommerce_after_edit_account_form', function() {
    echo sprintf('<div class="delete-me">%s</div>', do_shortcode( '[plugin_delete_me /]' ));
}, 10, 0 );