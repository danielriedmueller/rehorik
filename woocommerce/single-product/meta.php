<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (!function_exists('wc_gzd_get_product')) return;

global $product;
?>
<div class="rehorik-product-meta product_meta">
    <?php if ( wc_gzd_get_product( $product )->has_unit() ) : ?>
        <span class="rehorik-price-unit price-unit wc-gzd-additional-info">
            <?php echo wc_gzd_get_product( $product )->get_unit_price_html(); ?>
        </span>
    <?php endif; ?>
    <?php do_action( 'woocommerce_product_meta_start' ); ?>
    <?php
        foreach (WINE_CATEGORY_SLUGS as $wineCategorySlug) {
            if (isItCategory($product, $wineCategorySlug)) {
                echo "<span>enthält Sulfite</span>";
                break;
            }
        }
        if (isItCategory($product, GIFTS_CATEGORY_SLUG)) {
            echo '<span><a href="' . INGREDIENT_AND_NUTRITION_INFORMATION . '">Allergene & Inhaltsstoffe</a></span>';
        }
    ?>
    <?php do_action( 'woocommerce_product_meta_end' ); ?>
</div>
