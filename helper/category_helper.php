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
}

;

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
 * Vollautomat, Espresso, Filterkaffee,
 * return only one.
 *
 * Hierarchy
 *  - 1. Filterkaffee
 *  - 2. Espresso
 *  - 3. Vollautomat (crema)
 *
 * @param WC_Product $product
 * @return string
 */
function getPrimaryCoffeeCategory(WC_Product $product): string
{
    $name = null;

    if (isItCategory($product, COFFEE_FILTERKAFFEE_CATEGORY_SLUG)) {
        $name = getCategoryNameBySlug(COFFEE_FILTERKAFFEE_CATEGORY_SLUG);
    } elseif (isItCategory($product, COFFEE_ESPRESSO_CATEGORY_SLUG)) {
        $name = getCategoryNameBySlug(COFFEE_ESPRESSO_CATEGORY_SLUG);
    } elseif (isItCategory($product, COFFEE_CREMA_CATEGORY_SLUG)) {
        $name = getCategoryNameBySlug(COFFEE_CREMA_CATEGORY_SLUG);
    }

    return $name ? sprintf('%s - ', $name) : "";
}

/**
 * @param string $slug
 * @return string|null
 */
function getCategoryNameBySlug(string $slug)
{
    $cat = get_term_by('slug', $slug, 'product_cat');

    return $cat ? $cat->name : false;
}

/**
 * Overridden woocommerce function
 *
 * @param int $parent_id
 * @return array|false|mixed
 */
function woocommerce_get_product_subcategories($parent_id = 0)
{
    $parent_id = absint($parent_id);
    $cache_key = apply_filters('woocommerce_get_product_subcategories_cache_key', 'product-category-hierarchy-' . $parent_id, $parent_id);
    $product_categories = $cache_key ? wp_cache_get($cache_key, 'product_cat') : false;

    if (false === $product_categories) {
        // NOTE: using child_of instead of parent - this is not ideal but due to a WP bug ( https://core.trac.wordpress.org/ticket/15626 ) pad_counts won't work.
        $product_categories = get_categories(
            apply_filters(
                'woocommerce_product_subcategories_args',
                array(
                    'parent' => $parent_id,
                    'hide_empty' => 0,
                    'hierarchical' => 1,
                    'taxonomy' => 'product_cat',
                    'pad_counts' => 1,
                )
            )
        );

        if ($cache_key) {
            wp_cache_set($cache_key, $product_categories, 'product_cat');
        }
    }

    if (apply_filters('woocommerce_product_subcategories_hide_empty', true)) {
        $product_categories = wp_list_filter(
            $product_categories,
            array('count' => 0),
            'NOT'
        );
    }

    return $product_categories;
}

/**
 * Overriden woocommerce function
 *
 * Show the subcategory title in the product loop.
 *
 * @param object $category Category object.
 */
function woocommerce_template_loop_category_title($category)
{
    ?>
    <h2 class="woocommerce-loop-category__title">
        <span>
            <?php
            echo esc_html($category->name);

            if ($category->count > 0) {
                // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo apply_filters('woocommerce_subcategory_count_html', ' <mark class="count">(' . esc_html($category->count) . ')</mark>', $category);
            }
            ?>
        </span>
    </h2>
    <?php
}
