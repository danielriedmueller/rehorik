<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     4.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$seperator = ";";
$parentsList = array_reverse(array_filter(explode($seperator, get_term_parents_list(get_queried_object()->term_id, 'product_cat', [
    'format' => 'slug',
    'separator' => $seperator,
    'link' => false
]))));

$template = "";
foreach ($parentsList as $cat) {
    if (locate_template('templates/category/category-' . $cat . '.php')) {
        $template = $cat;
        break;
    }
}

get_template_part('templates/category/category', $template);