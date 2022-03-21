<?php
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 10);
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 15);
add_action( 'woocommerce_single_product_summary', 'rehorik_bio_sigil', 20);
add_action( 'woocommerce_single_product_summary', 'rehorik_single_product_attributes', 25);

function rehorik_single_product_attributes() {
    echo get_template_part('templates/product-single-attributes');
}

function rehorik_bio_sigil() {
    global $product;
    if(hasBiosigil($product)) {
        get_template_part('templates/bio-sigil', null, ['product' => $product]);
    }
}
