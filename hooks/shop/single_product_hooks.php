<?php
/**
 * Product Detail View Hooks
 */
remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices');
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

add_action('rehorik_product_title', 'woocommerce_template_single_title', 1); // Title
add_action('rehorik_product_title', 'title_claim', 1); // Claim
add_action('rehorik_product_title', 'short_description', 1); // Short Description
add_action('rehorik_product_title', 'quality_name', 1); // Quality Name
add_action('rehorik_product_title', 'woocommerce_output_all_notices', 1); // WooCommerce Notices

add_action('rehorik_product_gallery', 'woocommerce_show_product_images', 1); // Gallery
add_action('rehorik_product_gallery', 'sigils', 1); // Sigils
add_action('rehorik_product_gallery', 'product_video', 1); // Video

// Submit button block
add_action('woocommerce_after_add_to_cart_button', 'fire_after_submit_button_action');
add_action('woocommerce_after_add_to_cart_button', 'woocommerce_template_single_price', 1); // Price
add_action('woocommerce_after_add_to_cart_button', 'cup_of_coffee', 35); // Cup of Coffee
add_action( 'woocommerce_after_add_to_cart_button', 'woocommerce_template_single_meta', 40 ); // Meta
add_filter('woocommerce_paypal_payments_single_product_renderer_hook', function () {return 'woocommerce_after_add_to_cart_button';}); // Filter for rendering PayPal Button
add_action('rehorik_product_not_selling_notice', 'not_selling_notice', 1); // Notice if product is not selling

add_action('woocommerce_single_product_summary', 'hugo_head', 50); // Hugo Head

add_action('rehorik_product_information', 'description', 1); // Description
add_action('rehorik_product_information', 'title', 1); // Title
add_action('rehorik_product_information', 'single_product_attributes', 1); // Attributes

add_action('rehorik_product_preperation_recommendation', 'preperation_recommendation', 1); // Preperation Recommendation

add_action('rehorik_product_origin', 'origin', 1); // Description

add_action('woocommerce_after_single_product', 'woocommerce_output_related_products', 10);

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

function preperation_recommendation(): void {
    global $product;

    get_template_part('templates/product-preperation-recommendation', null, ['product' => $product]);
}

function title(): void {
    the_title( '<h2 class="rehorik-product-information-title">', '</h2>' );
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
