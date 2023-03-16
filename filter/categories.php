<?php
/**
 * Remove product category count.
 */
add_filter('woocommerce_subcategory_count_html', '__return_false');

/**
 * Add category slug to classes
 */
add_filter('product_cat_class', function ($classes, $class, $category) {
    $classes[] = $category->slug;

    return $classes;
}, 10, 3);

/**
 * Add event date sorting option
 */
add_filter('woocommerce_get_catalog_ordering_args', function ($args) {
    if (isProductCategory(TICKET_CATEGORY_SLUG)) {
        $args['orderby'] = 'meta_value';
        $args['order'] = 'ASC';
        $args['meta_key'] = TICKET_EVENT_DATE_START_META;
    }

    return $args;
});

add_filter('woocommerce_default_catalog_orderby', function (string $sortBy) {
    if (isProductCategory(TICKET_CATEGORY_SLUG)) {
        return 'sort_by_event_date';
    }

    return 'popularity';
});
add_filter('woocommerce_default_catalog_orderby_options', 'custom_woocommerce_catalog_orderby');
add_filter('woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby');
function custom_woocommerce_catalog_orderby(array $sortby): array
{
    if (isProductCategory(TICKET_CATEGORY_SLUG)) {
        $sortby = [];
        $sortby['sort_by_event_date'] = 'Veranstaltungsdatum';
    }

    return $sortby;
}

add_filter('woocommerce_product_categories_widget_args', function(array $args) {
    $catsIncluded = explode(',', $args['include']);

    if (!empty($catsIncluded)) {
        $args['include'] = implode(',', array_diff($catsIncluded, HIDE_CATEGORIES));
    }

    return $args;
});
