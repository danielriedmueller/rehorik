
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
<div class="rehorik-product-additional-information-container-outer woocommerce-tabs wc-tabs-wrapper">
    <ul class="tabs wc-tabs" role="tablist">
        <li class="details_tab" id="tab-title-details" role="tab" aria-controls="tab-details">
            <a href="#tab-details">Beschreibung</a>
        </li>
        <li class="video_tab" id="tab-title-video" role="tab" aria-controls="tab-video">
            <a href="#tab-video">Video</a>
        </li>
    </ul>
    <div class="rehorik-product-additional-information-container">
        <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--details panel entry-content wc-tab" id="tab-details" role="tabpanel" aria-labelledby="tab-title-details">
            <div class="rehorik-product-additional-information-category"><?php echo getCoffeeCategories($product) ?></div>
            <?php do_action( 'woocommerce_product_additional_information', $product ); ?>
            <?php echo apply_filters( 'the_content', $product->get_description() ) ?>
        </div>
        <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--video panel entry-content wc-tab" id="tab-video" role="tabpanel" aria-labelledby="tab-title-video">
            <?= $product->get_meta('Video') ?>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/RdGTPwIeOu8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
</div>