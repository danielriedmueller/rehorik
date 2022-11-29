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
 * @version 4.0.0
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

    $options = '';
    for ($count = $min_value; $count <= $max_value; $count = $count + $step) {
        $selected = $count === $input_value ? ' selected' : '';
        $options .= '<option value="' . $count . '"' . $selected . '>' . $count . '</option>';
    }
    echo '<div class="quantity" style="' . $defaults['style'] . '"><select name="' . esc_attr($defaults['input_name']) . '" title="' . _x('Qty',
            'Product Description', 'woocommerce') . '" class="cw_qty">' . $options . '</select></div>';

	?>
	<div class="quantity">
		<?php do_action( 'woocommerce_before_quantity_input_field' ); ?>
		<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_attr( $label ); ?></label>
		<input
			type="number"
			id="<?php echo esc_attr( $input_id ); ?>"
			class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
			step="<?php echo esc_attr( $step ); ?>"
			min="<?php echo esc_attr( $min_value ); ?>"
			max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
			name="<?php echo esc_attr( $input_name ); ?>"
			value="<?php echo esc_attr( $input_value ); ?>"
			title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ); ?>"
			size="4"
			placeholder="<?php echo esc_attr( $placeholder ); ?>"
			inputmode="<?php echo esc_attr( $inputmode ); ?>"
			autocomplete="<?php echo esc_attr( isset( $autocomplete ) ? $autocomplete : 'on' ); ?>"
		/>
		<?php do_action( 'woocommerce_after_quantity_input_field' ); ?>
	</div>
	<?php
}

/**
 *
function woocommerce_quantity_input($data = null)
{
global $product;
if (!$data) {
$defaults = [
'input_name' => 'quantity',
'input_value' => '1',
'max_value' => apply_filters('woocommerce_quantity_input_max', '', $product),
'min_value' => apply_filters('woocommerce_quantity_input_min', '', $product),
'step' => apply_filters('woocommerce_quantity_input_step', '1', $product),
'style' => apply_filters('woocommerce_quantity_style', 'float:left;', $product),
];
} else {
$defaults = [
'input_name' => $data['input_name'],
'input_value' => $data['input_value'],
'step' => apply_filters('cw_woocommerce_quantity_input_step', '1', $product),
'max_value' => apply_filters('cw_woocommerce_quantity_input_max', '', $product),
'min_value' => apply_filters('cw_woocommerce_quantity_input_min', '', $product),
'style' => apply_filters('cw_woocommerce_quantity_style', 'float:left;', $product),

];

}

if (!empty($defaults['min_value'])) {
$min = $defaults['min_value'];
} else {
$min = 0;
}

if (!empty($defaults['max_value'])) {
$max = $defaults['max_value'];
} else {
$max = 15;
}

if (!empty($defaults['step'])) {
$step = $defaults['step'];
} else {
$step = 1;
}

$options = '';
for ($count = $min; $count <= $max; $count = $count + $step) {
$selected = $count === $defaults['input_value'] ? ' selected' : '';
$options .= '<option value="' . $count . '"' . $selected . '>' . $count . '</option>';
}

echo '<div class="quantity" style="' . $defaults['style'] . '"><select name="' . esc_attr($defaults['input_name']) . '" title="' . _x('Qty',
'Product Description', 'woocommerce') . '" class="cw_qty">' . $options . '</select></div>';
}
 */