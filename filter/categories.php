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