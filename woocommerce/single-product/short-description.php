<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;
$productAtrributes = $product->get_attributes();

// Only show attributes not used otherwise on detail page
foreach (array_merge(INFORMATION_TAB_ATTRIBUTES, [STRENGTH_ATTRIBUTE_SLUG, FLAVOUR_VARIETY_ATTRIBUTE_SLUG]) as $attr) {
    unset($productAtrributes[$attr]);
}

?>
<div class="rehorik-product-short-description">
    <?php
        foreach ($productAtrributes as $attributeName => $attribute) {
            if ($attribute->get_visible() && $value = $product->get_attribute($attributeName)) {
                echo sprintf("<div><b>%s</b> %s</div>", wc_attribute_label($attributeName), $value);
            }
        }

        if (isItCategory($product, WINE_CATEGORY_SLUGS[0]) || isItCategory($product, WINE_CATEGORY_SLUGS[1]) || isItCategory($product, WINE_CATEGORY_SLUGS[2])) {
            echo "<div>enthält Sulfite</div>";
        }
    ?>
</div>
<?php
global $post;

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );
if (!$short_description) {
	return;
}

?>
<div class="woocommerce-product-details__short-description">
	<?php echo $short_description; // WPCS: XSS ok. ?>
</div>
