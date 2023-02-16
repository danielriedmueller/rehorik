<?php
/**
 * Product Detail View Hooks
 */
remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices');

add_action('rehorik_product_view', 'product_video', 1); // Video

add_action('rehorik_product_view_title_price', 'woocommerce_template_single_title', 1); // Title
add_action('rehorik_product_view_title_price', 'title_claim', 1); // Claim
add_action('rehorik_product_view_title_price', 'quality_name', 1); // Quality Name
add_action('rehorik_product_view_title_price', 'woocommerce_template_single_price', 1); // Price

add_action('rehorik_product_view_gallery', 'woocommerce_show_product_images', 1); // Gallery
add_action('rehorik_product_view_gallery', 'sigils', 1); // Sigils

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

add_action('woocommerce_single_product_summary', 'cup_of_coffee', 35); // Cup of Coffee
add_action('woocommerce_single_product_summary', 'hugo_head', 50); // Hugo Head

add_action('rehorik_product_view_not_selling_notice', 'not_selling_notice', 1); // Text if product can not be bought online

add_action('rehorik_product_view', 'short_description', 1); // Goes with
add_action('rehorik_product_view', 'goes_with', 1); // Goes with
add_action('rehorik_product_view', 'woocommerce_output_all_notices', 1); // Add to cart message

add_action('rehorik_product_information', 'description', 1); // Description
add_action('rehorik_product_information', 'categories', 1); // Categories
add_action('rehorik_product_information', 'single_product_attributes', 1); // Attributes
add_action('rehorik_product_information', 'preperation_recommendation', 1); // Preperation Recommendation

add_action('rehorik_product_origin', 'origin', 1); // Description

function description(): void {
    global $product;

    echo sprintf(
        '<div class="rehorik-product-description">%s</div>',
        $product->get_description()
    );
}

function short_description(): void {
    global $post;

    echo sprintf(
        '<div class="rehorik-product-short-description">%s</div>',
        $post->post_excerpt
    );
}

function origin(): void {
    global $post;
    global $product;

    $origin = get_post_meta($post->ID, 'rehorik_product_origin', true);

    $weingut = $product->get_attribute('weingut');

    if (!empty($weingut)) {
        echo sprintf(
            '<div class="rehorik-product-origin"><h4>Weingut %s</h4>%s</div>',
            $weingut,
            $post->post_excerpt
        );
    } else {
        echo sprintf(
            '<div class="rehorik-product-origin">%s</div>',
            $origin
        );
    }
}
function quality_name(): void {
    global $product;

    $qualityName = $product->get_attribute('qualitaetsbezeichnung');

    if (!empty($qualityName)) {
        echo sprintf(
            '<div class="rehorik-product-quality-name">%s</div>',
            $qualityName
        );
    }
}

function title_claim(): void {
    global $product;
    $claim = $product->get_meta('reh_product_title_claim');

    if (!empty($claim)) {
        echo sprintf(
            '<div class="rehorik-product-quality-name">%s</div>',
            $claim
        );
    }
}

function goes_with(): void {
    global $product;

    $goesWith = $product->get_attribute('passt-zu');
    $title = 'Passt zu';

    if (empty($goesWith)) {
        $goesWith = $product->get_attribute('aromen');
        $title = 'Aroma';
    }

    if (!empty($goesWith)) {
        $goesWith = str_replace(', ', ' - ', $goesWith);
        echo sprintf(
            '<div class="rehorik-product-goes-with"><div>%s</div><div>%s</div></div>',
            $title,
            $goesWith
        );
    }
}

function preperation_recommendation(): void {
    global $product;

    get_template_part('templates/product-preperation-recommendation', null, ['product' => $product]);
}

function categories(): void {
    global $product;
    $categories = getSubCategories($product);

    echo sprintf('<div class="rehorik-product-information-category">%s</div>', $categories);
}

function single_product_attributes(): void {
    global $product;

    // Manipulated by woocommerce_display_product_attributes filter
    wc_display_product_attributes($product);
}

function product_video(): void {
    global $product;

    get_template_part('templates/product-video', null, ['product' => $product]);
}

function sigils(): void {
    global $product;

    get_template_part('templates/product/sigils', null, ['product' => $product]);
}

function hugo_head(): void {
    echo '<div class="rehorik-hugo-head"></div>';
}

function cup_of_coffee(): void {
    global $product;

    get_template_part('templates/cup-of-coffee', null, ['product' => $product]);
}

function not_selling_notice(): void {
    get_template_part('templates/not-selling-notice');
}

remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
add_action('woocommerce_after_single_product', 'woocommerce_output_related_products', 10);
