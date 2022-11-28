<?php
require_once('admin/woocommerce/add_cat_video_field.php');
require_once('admin/woocommerce/add_product_preperation_recommendation_field.php');
require_once('admin/woocommerce/add_product_video_field.php');
require_once('shop/frontpage_categories.php');
require_once('admin/woocommerce/add_product_title_claim_field.php');

add_action('after_setup_theme', function () {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
});

/**
 * Removes breadcrumb.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

// Add delete account feature
add_action('woocommerce_after_edit_account_form', function () {
    echo sprintf('<div class="delete-me">%s</div>', do_shortcode('[plugin_delete_me /]'));
}, 10, 0);


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