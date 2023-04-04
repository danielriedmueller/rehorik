<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}
require_once(get_stylesheet_directory() . '/helper/product_attributes_helper.php');
?>
<div id="product-<?php the_ID(); ?>"
    <?php
    $class = 'rehorik-product detail-view';
    if (isProductOfTheMonth($product)) {
        $class .= " " . getProductOfTheMonthClass($product);
    }
    wc_product_class($class, $product);
    ?>
>
    <div class="rehorik-product-header">
        <div class="rehorik-product-title"><?php do_action('rehorik_product_title'); ?></div>
        <div class="rehorik-product-gallery"><?php do_action('rehorik_product_gallery'); ?></div>
        <div class="rehorik-add-to-cart-container">
            <?php isProductSelling($product)
                ? do_action('woocommerce_single_product_summary')
                : do_action('rehorik_product_not_selling_notice');
            ?>
        </div>
    </div>
    <div id="more-information" class="rehorik-product-information-outer"><?php do_action('rehorik_product_information'); ?></div>
    <div class="rehorik-product-textarea-outer hellbraun"><?php do_action('rehorik_product_processing'); ?></div>
    <div class="rehorik-product-textarea-outer"><?php do_action('rehorik_product_preperation_recommendation'); ?></div>
    <div class="rehorik-product-textarea-outer dunkelbraun"><?php do_action('rehorik_product_origin'); ?></div>
</div>
<div class="container">
    <?php do_action('woocommerce_after_single_product'); ?>
</div>

