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

/**
 * Checks if category page belongs to category
 *
 * Extension of is_product_category
 * Includes parent check
 *
 * @return bool
 */
function isProductCategory($slug):bool
{
    $cat = get_term_by( 'slug', $slug, 'product_cat' );
    $isAncestor = term_is_ancestor_of($cat->term_id, get_queried_object()->term_id, 'product_cat');

    return is_product_category($slug) || $isAncestor;
}

/**
 * Checks if product belongs to category
 *
 * @param $product
 * @param $categorySlug
 * @return bool
 */
function isItCategory($product, $categorySlug): bool
{
    if (is_a($product, 'WC_Product_Variation')) {
        $product = wc_get_product($product->get_parent_id());
    }

    if (!$product) return false;

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
 * return the first two of them.
 *
 * Hierarchy
 *  - 1. Filterkaffee
 *  - 2. Espresso
 *  - 3. Vollautomat (crema)
 *
 * @param WC_Product $product
 * @return string
 */
function getCoffeeCategories(WC_Product $product): string
{
    $terms = get_the_terms( $product->get_id(), 'product_cat' );
    $term_ids = wp_list_pluck($terms,'term_id');
    $parents = array_filter(wp_list_pluck($terms,'parent'));
    $term_ids_not_parents = array_diff($term_ids,  $parents);
    $terms_not_parents = array_intersect_key($terms,  $term_ids_not_parents);
    $filtered_terms = array_filter($terms_not_parents, function($a) {
        return in_array($a->slug, [
                COFFEE_FILTERKAFFEE_CATEGORY_SLUG, COFFEE_ESPRESSO_CATEGORY_SLUG, COFFEE_CREMA_CATEGORY_SLUG
        ]);
    });

    //Filter crema category if multiple categories
    if (sizeof($filtered_terms) > 1) {
        $filtered_terms = array_filter($filtered_terms, function($a) {
            return in_array($a->slug, [
                COFFEE_FILTERKAFFEE_CATEGORY_SLUG, COFFEE_ESPRESSO_CATEGORY_SLUG
            ]);
        });
    }

    $filtered_terms_names = array_unique(array_map(function ($a) {
        return $a->name;
    }, $filtered_terms));

    return sizeof($filtered_terms_names) > 0 ? implode(" & ", $filtered_terms_names) : "";
}

/**
 * Returns Subcategory of Product
 *
 * @param WC_Product $product
 * @return string
 */
function getSubCategory(WC_Product $product): string
{
    if (isItCategory($product, COFFEE_CATEGORY_SLUG)) {
        return getCoffeeCategories($product);
    }

    if (isItCategory($product, WINE_SPIRITS_CO_CATEGORY_SLUG)) {
        return "";
    }

    $terms = get_the_terms( $product->get_id(), 'product_cat' );
    $term_ids = wp_list_pluck($terms,'term_id');
    $parents = array_filter(wp_list_pluck($terms,'parent'));
    $term_ids_not_parents = array_diff($term_ids,  $parents);
    $terms_not_parents = array_intersect_key($terms,  $term_ids_not_parents);
    $terms_not_parents_names = array_map(function ($a) {
        return $a->name;
    }, $terms_not_parents);

    if (sizeof($terms_not_parents_names) > 0) {
        return $terms_not_parents_names[array_key_first($terms_not_parents_names)];
    }

    return "";
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
 * Decides wich categories should display on shop front page
 *
 * @return array
 */
function getShopFrontPageCategories()
{
    $parentCategories = get_categories([
        'parent' => 0,
        'hide_empty' => 0,
        'hierarchical' => 1,
        'taxonomy' => 'product_cat'
    ]);

    $onlineshopCategoryKey = array_search(ONLINESHOP_CATEGORY_SLUG, array_column($parentCategories, 'slug'));
    $onlineshopCategories = get_categories(           [
        'parent' => $parentCategories[$onlineshopCategoryKey]->term_id,
        'hide_empty' => 1,
        'hierarchical' => 1,
        'taxonomy' => 'product_cat',
        'pad_counts' => 1
    ]);

    // Add delivery category
    $deliveryCategoryKey = array_search(DELIVERY_CATEGORY_SLUG, array_column($parentCategories, 'slug'));
    $onlineshopCategories[] = $parentCategories[$deliveryCategoryKey];

    // Add events category
    $eventsCategoryKey = array_search(TICKET_CATEGORY_SLUG, array_column($parentCategories, 'slug'));
    // TODO: Uncomment this on ticket release
    // $onlineshopCategories[] = $parentCategories[$eventsCategoryKey];

    return $onlineshopCategories;
}

/**
 * Overridden woocommerce function
 * Onlineshp category id = 659
 *
 * @param int $parent_id
 * @return array|false|mixed
 */
function woocommerce_get_product_subcategories($parent_id = 0)
{
    $parent_id = absint($parent_id);

    if ($parent_id === 0) {
        return getShopFrontPageCategories();
    }

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

    if ( apply_filters( 'woocommerce_product_subcategories_hide_empty', true ) ) {
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
    if (!empty($category->description)) {
        ?>
            <div class="rehorik-category-description"><?= $category->description ?></div>
        <?php
    }
}

/**
 * Returns one product subcategory for onlineshop or delivery
 * depending on $referer Page
 * The first element is used in sidebar product category list
 * Checks if its for delivery or shipping
 *
 * @param $terms
 * @return array
 */
function findShoptypeAwareProductSubcategory($terms) {
    if (!isset($_SERVER['HTTP_REFERER'])) {
        return $terms;
    }
    $referer = $_SERVER['HTTP_REFERER'];

    $term_ids = wp_list_pluck($terms,'term_id');
    $parents = array_filter(wp_list_pluck($terms,'parent'));
    $term_ids_not_parents = array_diff($term_ids,  $parents);
    $terms_not_parents = array_intersect_key($terms,  $term_ids_not_parents);

    $shoptypeAwareSubcategory = [];
    $seperator = ";";

    foreach ($terms_not_parents as $key => $term) {
        $parentSlugs = explode($seperator, get_term_parents_list($term->term_id, 'product_cat', [
            'format' => 'slug',
            'separator' => $seperator,
            'link' => false,
            'inclusive' => false
        ]));
        if (in_array(DELIVERY_CATEGORY_SLUG, $parentSlugs)) {
            $shoptypeAwareSubcategory[DELIVERY_CATEGORY_SLUG] = $term;
        } else {
            $shoptypeAwareSubcategory[ONLINESHOP_CATEGORY_SLUG] = $term;
        }
    }

    // Is delivery
    if (substr_count($referer, DELIVERY_CATEGORY_URL) === 1) {
        if (isset($shoptypeAwareSubcategory[DELIVERY_CATEGORY_SLUG])) {
            return [$shoptypeAwareSubcategory[DELIVERY_CATEGORY_SLUG]];
        }
    }

    return [$shoptypeAwareSubcategory[ONLINESHOP_CATEGORY_SLUG]];
}

function syncEventCategoriesToProductCategories() {
    //Map event catgegories with woocommerce categories
    $eventCats = get_terms(TribeEvents::TAXONOMY, array('hide_empty' => 0));
    $eventParentProductCat = get_term_by('slug', TICKET_CATEGORY_SLUG, 'product_cat');

    foreach ($eventCats as $eventCat) {
        $existingCat = get_term_by('slug', $eventCat->slug, 'product_cat');

        if ($eventCat->parent === 0) {
            $productParentCat = $eventParentProductCat;
        } else {
            $eventParentCat = get_term($eventCat->parent, TribeEvents::TAXONOMY);
            $productParentCat = get_term_by('slug', $eventParentCat->slug, 'product_cat');
        }

        if ($productParentCat) {
            if (!$existingCat) {
                wp_insert_term( $eventCat->name, 'product_cat', array(
                    'parent' => $productParentCat->term_id, // optional
                    'slug' => $eventCat->slug // optional
                ));
            } else {
                wp_update_term($existingCat->term_id, 'product_cat', array(
                    'name' => $eventCat->name,
                    'parent' => $productParentCat->term_id, // optional
                    'slug' => $eventCat->slug // optional
                ));
            }
        }
    }
}
