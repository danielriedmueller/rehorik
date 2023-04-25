<?php
/**
 * Product Detail View Hooks
 */
remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices');
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

add_action('rehorik_product_title', 'woocommerce_template_single_title', 1); // Title
add_action('rehorik_product_title', 'quality_name', 2); // Quality Name
add_action('rehorik_product_title', 'title_claim', 3); // Claim
add_action('rehorik_product_title', 'short_description', 4); // Short Description
add_action('rehorik_product_title', 'woocommerce_output_all_notices', 5); // WooCommerce Notices

add_action('rehorik_product_gallery', 'woocommerce_show_product_images', 1); // Gallery
add_action('rehorik_product_gallery', 'sigils', 1); // Sigils
add_action('rehorik_product_gallery', 'product_video', 1); // Video

// Submit button block
add_action('woocommerce_after_add_to_cart_button', 'woocommerce_template_single_price', 1); // Price
add_action('woocommerce_after_add_to_cart_button', 'cup_of_coffee', 35); // Cup of Coffee
add_action('woocommerce_after_add_to_cart_button', 'woocommerce_template_single_meta', 40); // Meta
add_filter('woocommerce_paypal_payments_single_product_renderer_hook', function () {
    return 'woocommerce_after_add_to_cart_button';
}); // Filter for rendering PayPal Button
add_action('rehorik_product_not_selling_notice', 'not_selling_notice', 1); // Notice if product is not selling

add_action('woocommerce_single_product_summary', 'hugo_head', 50); // Hugo Head

add_action('rehorik_product_information', 'product_information', 1); // Information

add_action('rehorik_product_preperation_recommendation', 'preperation_recommendation', 1); // Preperation Recommendation

add_action('rehorik_product_origin', 'origin', 1); // Description

add_action('rehorik_product_processing', 'processing', 1); // Description

add_action('woocommerce_after_single_product', 'woocommerce_output_related_products', 10);

function product_information(): void
{
    get_template_part('templates/product/information');
}

function short_description(): void
{
    global $post;

    echo sprintf(
        '<div class="rehorik-product-short-description">%s</div>',
        apply_filters('the_content', $post->post_excerpt)
    );
}

function origin(): void
{
    global $post;

    if (!empty($origin = get_post_meta($post->ID, 'rehorik_product_origin', true))) {
        global $product;

        if (!empty($weingut = $product->get_attribute('weingut'))) {
            echo sprintf(
                '<div class="rehorik-product-origin weingut"><h2>Weingut %s</h2>%s</div>',
                $weingut,
                apply_filters('the_content', $origin)
            );
        } else {
            echo sprintf(
                '<div class="rehorik-product-origin">
                            <h2>Herkunft</h2>
                            <div>%s</div>
                            <div class="origin-images">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>',
                apply_filters('the_content', $origin)
            );
        }
    }
}

function processing(): void
{
    global $post;

    $preparation = get_post_meta($post->ID, 'rehorik_product_processing', true);

    if (!empty($preparation)) {
        echo sprintf(
            '<div class="rehorik-product-processing"><h2>Aufbereitung</h2><div>%s</div></div>',
            apply_filters('the_content', $preparation)
        );
    }
}

function quality_name(): void
{
    global $product;

    $qualityName = $product->get_attribute('qualitaetsbezeichnung');

    if (!empty($qualityName)) {
        echo sprintf(
            '<div class="rehorik-product-quality-name">%s</div>',
            $qualityName
        );
    }
}

function title_claim(): void
{
    global $product;
    $claim = $product->get_meta('reh_product_title_claim');

    if (!empty($claim)) {
        echo sprintf(
            '<div class="rehorik-product-title-claim">%s</div>',
            $claim
        );
    }
}

function preperation_recommendation(): void
{
    global $product;

    get_template_part('templates/product/preperation-recommendation', null, ['product' => $product]);
}

function product_video(): void
{
    global $product;

    get_template_part('templates/product/video', null, [
        'video' => $product->get_meta('reh_product_video')
    ]);
}

function sigils(): void
{
    global $product;

    get_template_part('templates/product/sigils', null, ['product' => $product]);
}

function hugo_head(): void
{
    echo '<div class="rehorik-hugo-head"></div>';
}

function cup_of_coffee(): void
{
    global $product;

    get_template_part('templates/product/cup-of-coffee', null, ['product' => $product]);
}

function not_selling_notice(): void
{
    get_template_part('templates/product/not-selling-notice');
}
