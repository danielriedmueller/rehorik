
<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
global $product;
?>
<div class="rehorik-product-additional-information-container-outer">
    <div class="rehorik-product-additional-information-container">
        <div class="rehorik-product-additional-information-category">
            <?php echo getCoffeeCategories($product) ?>
        </div>

        <?php do_action( 'woocommerce_product_additional_information', $product ); ?>
        <?php echo apply_filters( 'the_content', $product->get_description() ) ?>
    </div>
</div>