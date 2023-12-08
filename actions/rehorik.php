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

    echo sprintf(
        '<div class="rehorik-shipping-rest-amount">%s</div>',
        $restAmount > 0
            ? "Noch ${restAmount} &euro; bis zum kostenlosen Versand"
            : "Kostenloser Versand möglich!"
    );
});

//Remove JQuery migrate
add_action('wp_default_scripts', function ($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];

        if ($script->deps) { // Check whether the script has any dependencies
            $script->deps = array_diff($script->deps, array(
                'jquery-migrate'
            ));
        }
    }
});

// Prevent PayPal loading in every page
add_action('wp_enqueue_scripts', function () {
    if (!is_product() && !is_cart() && !is_checkout()) {
        wp_dequeue_script('ppcp-smart-button');
    }
}, 20);
