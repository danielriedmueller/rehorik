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
 * Change default sorting depending on category
 *
 * Add event date sorting option for events
 */
add_filter('woocommerce_get_catalog_ordering_args', function ($args) {
    if ($args['orderby'] === 'default' || $args['orderby'] === 'menu_order title') {
        if (isProductCategory(TICKET_CATEGORY_SLUG)) {
            $args['orderby'] = 'meta_value';
            $args['order'] = 'ASC';
            $args['meta_key'] = TICKET_EVENT_DATE_START_META;
        } else {
            $args['orderby'] = 'popularity';
        }
    }

    return $args;
});

add_filter('woocommerce_product_categories_widget_args', function(array $args) {
    $catsIncluded = explode(',', $args['include']);

    if (!empty($catsIncluded)) {
        $args['include'] = implode(',', array_diff($catsIncluded, HIDE_CATEGORIES));
    }

    return $args;
});
