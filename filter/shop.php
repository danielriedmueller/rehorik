<?php
/**
 * Adds class to body classes for shop page only.
 */
add_filter('body_class', function ($classes) {
    if (is_shop()) {
        return array_merge($classes, array('shop'));
    }

    return $classes;
});

/**
 * Removes page title in content area.
 */
add_filter('woocommerce_show_page_title', function () {
    return false;
});

add_filter('woocommerce_shipping_rate_label', function (string $label, WC_Shipping_Rate $method) {
    $message = 'Lieferzeit: 3 - 5 Werktage';
    if ($method->get_method_id() === 'local_pickup') {
        $message = 'Abholbar in 2 Werktagen zwischen 9 - 18 Uhr im Kaffeehaus, Straubinger Str. 62A';
    }

    return "$label<br><span>$message</span>";
}, 10, 2);

/**
 * Remove Ancient Custom Fields metabox from post editor
 * because it uses a very slow query meta_key sort query
 * so on sites with large postmeta tables it is super slow
 * and is rarely useful anymore on any site
 */
function s9_remove_post_custom_fields_metabox()
{
    foreach (get_post_types('', 'names') as $post_type) {
        remove_meta_box('postcustom', $post_type, 'normal');
    }
}

add_action('admin_menu', 's9_remove_post_custom_fields_metabox');

/*
* Reduce the strength requirement for woocommerce registration password.
* Strength Settings:
* 0 = Nothing = Anything
* 1 = Weak
* 2 = Medium
* 3 = Strong (default)
*/
add_filter('woocommerce_min_password_strength', 'wpglorify_woocommerce_password_filter', 10);
function wpglorify_woocommerce_password_filter()
{
    return 2;
} //2 represent medium strength password

/**
 * Change number of products that are displayed per page (shop page)
 */
add_filter('loop_shop_per_page', function ($cols) {
    return PRODUCTS_PER_PAGE;
}, 20);
