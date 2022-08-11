<?php
/**
 * Checks if category page belongs to category
 *
 * Extension of is_product_category
 * Includes parent check
 */
function isProductCategory($slug): bool
{
    $queriedObject = get_queried_object();
    if (!is_a($queriedObject, WP_Term::class)) {
        return false;
    }

    $cat = get_term_by( 'slug', $slug, 'product_cat');
    $isAncestor = term_is_ancestor_of($cat->term_id, $queriedObject->term_id, 'product_cat');

    return is_product_category($slug) || $isAncestor;
}

function getProductCategorySlug(): string
{
    return get_term(get_queried_object()->term_id)->slug;
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
 * Returns Subcategories of Product.
 * If no subcategories, returns category.
 *
 * @param WC_Product $product
 * @return string
 */
function getSubCategories(WC_Product $product, $linked = false): string
{
    $nameMapFn = function ($a) use ($linked) {
        return $linked ? '<a href="' . get_term_link($a) . '">' . $a->name . '</a>' : $a->name;
    };

    $terms = get_the_terms( $product->get_id(), 'product_cat' );

    // Dont show "Vollautomat", if coffee is also "Espresso" or "Filterkaffee"
    if (isItCategory($product, COFFEE_CATEGORY_SLUG) && sizeof($terms) > 1) {
        $terms = array_filter($terms, function($a) {
            return $a->slug !== COFFEE_CREMA_CATEGORY_SLUG;
        });
    }

    $term_ids = wp_list_pluck($terms,'term_id');
    $parents = array_filter(wp_list_pluck($terms,'parent'));
    $term_ids_not_parents = array_diff($term_ids,  $parents);
    $terms_not_parents = array_intersect_key($terms,  $term_ids_not_parents);

    $onlineshop_cat = get_term_by('slug', ONLINESHOP_CATEGORY_SLUG, 'product_cat');
    $terms_not_onlineshop_cat_parent = array_filter($terms_not_parents, function (WP_Term $a) use ($onlineshop_cat) {
        return $a->parent !== $onlineshop_cat->term_id;
    });

    $terms_not_parents_names = array_map($nameMapFn, $terms_not_onlineshop_cat_parent);

    if (sizeof($terms_not_parents_names) > 0) {
        return implode(", ", $terms_not_parents_names);
    }

    $terms_names = array_map($nameMapFn , $terms);

    return implode(", ", $terms_names);
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
 * Decides which categories should display on shop front page
 *
 * @return array
 */
function getShopFrontPageCategories()
{
    $frontPageCategories = [];

    $categories = get_categories([
        'hide_empty' => 0,
        'taxonomy' => 'product_cat'
    ]);

    $keys = array_column($categories, 'slug');

    $frontPageCategories[] = $categories[array_search(MACHINE_CATEGORY_SLUG, $keys)];
    $frontPageCategories[] = $categories[array_search(WINE_CATEGORY_SLUG, $keys)];
    $frontPageCategories[] = $categories[array_search(SPIRITS_CATEGORY_SLUG, $keys)];
    $frontPageCategories[] = $categories[array_search(TICKET_CATEGORY_SLUG, $keys)];

    return $frontPageCategories;
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
 * Show subcategory thumbnails.
 *
 * @param mixed $category Category.
 */
function woocommerce_subcategory_thumbnail( $category ) {
    $small_thumbnail_size = apply_filters( 'subcategory_archive_thumbnail_size', 'woocommerce_thumbnail' );
    $dimensions           = wc_get_image_size( $small_thumbnail_size );
    $thumbnail_id         = get_term_meta( $category->term_id, 'thumbnail_id', true );
    $video                = get_term_meta( $category->term_id, 'reh_cat_video', true );

    if ( $thumbnail_id ) {
        $image        = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size );
        $image        = $image[0];
        $image_srcset = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $thumbnail_id, $small_thumbnail_size ) : false;
        $image_sizes  = function_exists( 'wp_get_attachment_image_sizes' ) ? wp_get_attachment_image_sizes( $thumbnail_id, $small_thumbnail_size ) : false;
    } else {
        $image        = wc_placeholder_img_src();
        $image_srcset = false;
        $image_sizes  = false;
    }

    if ( $image ) {
        // Prevent esc_url from breaking spaces in urls for image embeds.
        // Ref: https://core.trac.wordpress.org/ticket/23605.
        $image = str_replace( ' ', '%20', $image );

        // Add responsive image markup if available.
        if ( $image_srcset && $image_sizes ) {
            echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" srcset="' . esc_attr( $image_srcset ) . '" sizes="' . esc_attr( $image_sizes ) . '" />';
        } else {
            echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" />';
        }
    }

    if ($video) {
        echo(sprintf(
                '<video muted loop playsinline preload="none"><source src="%s"/></video>',
            wp_get_attachment_url($video)
        ));
    }
}
