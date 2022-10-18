<?php
require_once('admin/woocommerce/add_cat_video_field.php');
require_once('admin/woocommerce/add_product_preperation_recommendation_field.php');
require_once('admin/woocommerce/add_product_video_field.php');
require_once('shop/frontpage_categories.php');
require_once('admin/woocommerce/add_product_title_claim_field.php');
require_once('shop/offline_event_ticket_purchase.php');
require_once('shop/create_coupon.php');

add_action('after_setup_theme', function () {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
});

/**
 * Removes breadcrumb.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

// Add delete account feature
add_action('woocommerce_after_edit_account_form', function () {
    echo sprintf('<div class="delete-me">%s</div>', do_shortcode('[plugin_delete_me /]'));
}, 10, 0);

/**
 * Hide specific categories
 *
 * TODO: Remove when Delikatessen and Geschenkkörbe are being sold again
 */
add_filter('get_terms', function ($terms, $taxonomies, $args) {
    $new_terms = [];

    // if a product category and on the shop page
    if (in_array('product_cat', $taxonomies) && !is_admin()) {
        foreach ($terms as $key => $term) {
            if (!in_array($term->slug, HIDE_CATEGORIES)) {
                $new_terms[] = $term;
            }
        }
        $terms = $new_terms;
    }
    return $terms;
}, 10, 3);
