<?php
/**
 * Product Detail View Hooks
 *  - woocommerce_show_product_images
 *  - rehorik_product_view_title_price
 *      - woocommerce_template_single_title
 *      - woocommerce_template_single_price
 *  - preparation_recommendation
 *  - rehorik_product_view_add_to_cart
 *      - woocommerce_template_single_add_to_cart
 *      - woocommerce_template_single_meta
 *      - cup_of_coffee
 *      - hugo_head
 *  - rehorik_product_information
 *      - single_product_attributes (with category)
 *      - description
 *  - sigils
 *  - product_video
 */

add_action('rehorik_product_view', 'product_video', 1); // Video

add_action('rehorik_product_view_title_price', 'woocommerce_template_single_title', 1); // Title
add_action('rehorik_product_view_title_price', 'woocommerce_template_single_price', 1); // Price

add_action('rehorik_product_view_gallery', 'woocommerce_show_product_images', 1); // Gallery
add_action('rehorik_product_view_gallery', 'sigils', 1); // Sigils

add_action('rehorik_product_view_add_to_cart', 'hugo_head', 1); // Hugo Head
add_action('rehorik_product_view_add_to_cart', 'woocommerce_template_single_add_to_cart', 1); // Variations / Add to cart
add_action('rehorik_product_view_add_to_cart', 'cup_of_coffee', 1); // Cup of Coffee
add_action('rehorik_product_view_add_to_cart', 'woocommerce_template_single_meta', 1); // Meta

add_action('rehorik_product_view', 'goes_with', 1); // Meta

add_action('rehorik_product_information', 'description', 1); // Description
add_action('rehorik_product_information', 'categories', 1); // Categories
add_action('rehorik_product_information', 'single_product_attributes', 1); // Attributes
add_action('rehorik_product_information', 'short_description', 1); // Short Description
add_action('rehorik_product_information', 'preperation_recommendation', 1); // Preperation Recommendation

function description() {
    global $product;

    echo sprintf(
        '<div class="rehorik-product-description">%s</div>',
        $product->get_description()
    );
}

function short_description() {
    global $post;

    echo sprintf(
        '<div class="rehorik-product-short-description">%s</div>',
        $post->post_excerpt
    );
}

function goes_with() {
    global $product;

    $text = $product->get_meta('reh_goes_with_recommendation');
    if (!empty($text)) {
        echo sprintf(
            '<div class="rehorik-product-goes-with">Passt zu %s</div>',
            $text
        );
    }
}

function preperation_recommendation() {
    global $product;

    echo sprintf(
        '<div class="rehorik-recommendation">%s</div>',
        $product->get_meta('reh_preperation_recommendation')
    );
}

function categories() {
    global $product;
    $categories = getSubCategories($product);

    echo sprintf('<div class="rehorik-product-information-category">%s</div>', $categories);
}

function single_product_attributes() {
    global $product;

    wc_display_product_attributes($product);
}

function product_video() {
    global $product;

    get_template_part('templates/product-video', null, ['product' => $product]);
}

function sigils() {
    global $product;

    if(hasBiosigil($product)) {
        get_template_part('templates/bio-sigil', null, ['product' => $product]);
    }
}

function hugo_head() {
    echo '<div class="rehorik-hugo-head"></div>';
}

function cup_of_coffee() {
    global $product;

    get_template_part('templates/cup-of-coffee', null, ['product' => $product]);
}

remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
add_action('woocommerce_after_single_product', 'woocommerce_output_related_products', 10);