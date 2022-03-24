<?php
// TODO Remove after divi is removed
add_action('init' , 'remove_functions' , 15 );
function remove_functions() {
    remove_action( 'woocommerce_before_single_product_summary', 'et_divi_output_product_wrapper', 0  );
    remove_action( 'woocommerce_after_single_product_summary', 'et_divi_output_product_wrapper_end', 0  );
}


remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 10);
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 15);

add_action( 'woocommerce_after_single_product_summary', 'rehorik_bio_sigil', 5);
add_action( 'woocommerce_after_single_product_summary', 'rehorik_single_product_attributes', 5);
//add_action( 'woocommerce_after_single_product_summary', 'rehorik_hugo_head', 5);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

add_action('woocommerce_after_single_product', 'woocommerce_output_related_products', 10);


function rehorik_single_product_attributes() {
    echo get_template_part('templates/product-single-attributes');
}

function rehorik_bio_sigil() {
    global $product;
    if(hasBiosigil($product)) {
        get_template_part('templates/bio-sigil', null, ['product' => $product]);
    }
}

function rehorik_hugo_head() {
    echo '<div class="rehorik-hugo-head"></div>';
}