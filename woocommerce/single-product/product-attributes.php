<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-attributes.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

if (!$product_attributes) {
	return;
}

$baseDir = get_stylesheet_directory();
require_once($baseDir . '/helper/product_attributes_helper.php');

$strengthAndFlavour = extractStrengthAndFlavourAttributes($product_attributes);
$otherAttributes = extractOtherAttributes($product_attributes);

?>
<div class="rehorik-product-strength-flavour-container-outer">
    <?php foreach ($strengthAndFlavour as $product_attribute_key => $product_attribute) : ?>
            <div class="rehorik-product-attribute-label"><?php echo wp_kses_post( $product_attribute['label'] ); ?></div>
            <?php do_action(
                'render_product_attribute_strength_flavour',
                $product_attribute['value'],
                $product_attribute_key
            ); ?>
    <?php endforeach; ?>

</div>
<?php if (!empty($strengthAndFlavour)): ?>
    <hr>
<?php endif; ?>
<div class="product-rehorik-attribute-container item-count-<?= sizeof($otherAttributes) ?>">
    <?php foreach ($otherAttributes as $product_attribute_key => $product_attribute) : ?>
        <div class="rehorik-product-attribute-item">
            <div class="rehorik-product-attribute-label">
                <?php echo wp_kses_post( $product_attribute['label'] ); ?>
            </div>
            <div class="rehorik-product-attribute-value">
                <?php echo wp_kses_post( $product_attribute['value'] ); ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
