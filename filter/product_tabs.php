<?php

/**
 * Rename product data tabs
 */

function woo_rename_tabs( $tabs ) {

    $tabs['description']['title'] = 'Beschreibung';
    $tabs['additional_information']['title'] = 'Information';

    $tabs['description']['priority'] = 20;
    $tabs['additional_information']['priority'] = 15;

    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );

add_filter( 'wc_product_enable_dimensions_display', '__return_false' );