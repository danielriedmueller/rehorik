<?php
require_once('admin/rehorik/admin_rehorik.php');

/**
 * Renders free shipping amount hint.
 */
add_action('render_free_shipping_amount', function () {
    $minAmount = getFreeShippingAmount();

    echo '<span>' . $minAmount . ' &euro;</span>';
});

/**
 * Renders rest amount for free shipping.
 */
add_action('render_rest_amount_for_free_shipping', function () {
    $restAmount = getAmountTillFreeShipping();
    $restAmount = str_replace('.', ',', $restAmount);

    if ($restAmount > 0) {
        echo 'Nur noch <span>' . $restAmount . ' &euro;</span> bis zum kostenlosen Versand!';
    }
});

//Remove JQuery migrate
add_action('wp_default_scripts', function($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];

        if ($script->deps) { // Check whether the script has any dependencies
            $script->deps = array_diff($script->deps, array(
                'jquery-migrate'
            ));
        }
    }
});