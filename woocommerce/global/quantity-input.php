<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.2.1
 */

defined( 'ABSPATH' ) || exit;

if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
} else {
	/* translators: %s: Quantity. */
	$label = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'woocommerce' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'woocommerce' );

    if (empty($max_value)) {
        $max_value = DEFAULT_MAX_PRODUCT_STOCK_INPUT;
    }

    if ($input_value > $max_value) {
        $max_value = $input_value;
    }

    if (empty($min_value)) {
        $min_value = 0;
    }

    $options = '';
    for ($count = $min_value; $count <= $max_value; $count = $count + $step) {
        $selected = $count === $input_value ? ' selected' : '';
        $options .= '<option value="' . $count . '"' . $selected . '>' . $count . '</option>';
    }
	?>
    <div class="quantity">
        <?php do_action( 'woocommerce_before_quantity_input_field' ); ?>
        <select
            id="<?php echo esc_attr( $input_id ); ?>"
            class="rehorik-quantity input-text qty text <?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
            name="<?php echo esc_attr( $input_name ); ?>"
            title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ); ?>"
            placeholder="<?php echo esc_attr( $placeholder ); ?>"
            inputmode="<?php echo esc_attr( $inputmode ); ?>"
        ><?= $options ?></select>
        <?php do_action( 'woocommerce_after_quantity_input_field' ); ?>
    </div>
	<?php
}
