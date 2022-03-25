<?php

/**
 * Product Detail View Hooks
 *  - Gallery
 *  - Title
 *  - Price
 *  - Preperation Recommendation
 *  - Rehorik-add-to-cart-container (HTML Container)
 *      - Variations / Add to cart
 *      - Meta
 *      - Cup of Coffee
 *      - Hugo Head
 *  - Attributes
 *  - Category
 *  - Sigils
 *  - Description
 *  - Video
 */
add_action('rehorik_product_view', 'woocommerce_show_product_images', 1); // Gallery
add_action('rehorik_product_view', 'woocommerce_template_single_title', 1); // Title
add_action('rehorik_product_view', 'woocommerce_template_single_price', 1); // Price
add_action('rehorik_product_view', 'sigils', 1); // Sigils
add_action('rehorik_product_view', 'description', 1); // Description
add_action('rehorik_product_view', 'product_video', 1); // Video
add_action('rehorik_product_view', 'preparation_recommendation', 1); // Preperation Recommendation
add_action('rehorik_product_view', 'single_product_attributes', 1); // Attributes
add_action('rehorik_product_view', 'category', 1); // Category

add_action('rehorik_product_view_add_to_cart', 'hugo_head', 1); // Hugo Head
add_action('rehorik_product_view_add_to_cart', 'woocommerce_template_single_add_to_cart', 1); // Variations / Add to cart
add_action('rehorik_product_view_add_to_cart', 'cup_of_coffee', 1); // Cup of Coffee
add_action('rehorik_product_view_add_to_cart', 'woocommerce_template_single_meta', 1); // Meta

function description() {
    global $product;

    echo sprintf('<div class="rehorik-product-description">%s</div>', $product->get_description());
}

function category() {
    global $product;

    // TODO Wine Categories?
    echo sprintf(
        '<div class="rehorik-product-category">%s</div>',
        getCoffeeCategories($product)
    );
}

function single_product_attributes() {
    global $product;

    do_action( 'woocommerce_product_additional_information', $product );
}

function preparation_recommendation() {
    global $post;

    echo sprintf(
        '<div class="rehorik-preperation-recommendation">%s</div>',
        $post->post_excerpt
    );
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