<?php

function getCategoryTreeDepth($termId, $taxonomy = "product_cat"): int
{
    echo $termId;
    $seperator = ";";
    $parentsList = get_term_parents_list($termId, $taxonomy, [
        'format' => 'slug',
        'separator' => $seperator,
        'link' => false
    ]);

    return sizeof(explode($seperator, $parentsList)) - 1;
};

function isItCategory($product, $categorySlug): bool
{
    $taxonomy = 'product_cat';
    $seperator = ";";
    $allCategories = [];

    foreach ($product->get_category_ids() as $category_id) {
        $term = get_term($category_id, $taxonomy);
        $allCategories[] = $term->slug;
        $parents = get_term_parents_list($category_id, $taxonomy, [
            'format' => 'slug',
            'separator' => $seperator,
            'link' => false,
            'inclusive' => false
        ]);
        $allCategories = array_merge($allCategories, explode($seperator, $parents));

    }

    return in_array($categorySlug, $allCategories);
}

/**
 * Overwrites category link function for link to lieferservice page
 *
 * @param $category
 */
function woocommerce_template_loop_category_link_open($category) {
    /*
    if (is_shop() && $category->slug === DELIVERY_CATEGORY_SLUG) {
        echo '<a href="' . get_page_link(8570) . '">';
    } else {

    }
    */
    echo '<a href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '">';
}

function woocommerce_get_product_subcategories( $parent_id = 0 ) {
    $parent_id          = absint( $parent_id );
    $cache_key          = apply_filters( 'woocommerce_get_product_subcategories_cache_key', 'product-category-hierarchy-' . $parent_id, $parent_id );
    $product_categories = $cache_key ? wp_cache_get( $cache_key, 'product_cat' ) : false;

    if ( false === $product_categories ) {
        // NOTE: using child_of instead of parent - this is not ideal but due to a WP bug ( https://core.trac.wordpress.org/ticket/15626 ) pad_counts won't work.
        $product_categories = get_categories(
            apply_filters(
                'woocommerce_product_subcategories_args',
                array(
                    'parent'       => $parent_id,
                    'hide_empty'   => 0,
                    'hierarchical' => 1,
                    'taxonomy'     => 'product_cat',
                    'pad_counts'   => 1,
                )
            )
        );

        if ( $cache_key ) {
            wp_cache_set( $cache_key, $product_categories, 'product_cat' );
        }
    }

    if ( apply_filters( 'woocommerce_product_subcategories_hide_empty', true ) ) {
        $cat = wp_list_filter(
            $product_categories,
            array('slug' => DELIVERY_CATEGORY_SLUG),
            'AND'
        );

        $product_categories = wp_list_filter(
            $product_categories,
            array('count' => 0),
            'NOT'
        );

        $product_categories = array_merge($product_categories, $cat);
    }

    return $product_categories;
}
