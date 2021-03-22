<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

global $product;
$productAtrributes = $product->get_attributes();

// Only show attributes not used otherwise on detail page
foreach (array_merge(INFORMATION_TAB_ATTRIBUTES, [STRENGTH_ATTRIBUTE_SLUG, FLAVOUR_VARIETY_ATTRIBUTE_SLUG, PRODUCT_OF_MONTH_ATTRIBUTE_SLUG]) as $attr) {
    unset($productAtrributes[$attr]);
}

?>
<div class="rehorik-product-single-attributes">
    <?php
    foreach ($productAtrributes as $attributeName => $attribute) {
        if ($attribute->get_visible() && $value = $product->get_attribute($attributeName)) {
            echo sprintf("<div><b>%s</b> %s</div>", wc_attribute_label($attributeName), $value);
        }
    }
    ?>
</div>
<?php