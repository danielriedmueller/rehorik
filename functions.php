<?php
show_admin_bar(true);

require_once('sig_functions.php');

define('WP_SCSS_ALWAYS_RECOMPILE', true);

define('ONE_CUP_OF_COFFEE_IN_GRAMS', 10);
define('FREE_SHIPPING_AMOUNT', 49);
define('MAX_COFFEE_STRENGTH_FLAVOUR_ATTRIBUTE', 6);
define('MAX_DISPLAY_ORIGIN_COUNTRIES', 1);
define('DELIVERY_CATEGORY_URL', 'produkt-kategorie/lieferservice');
define('EVENT_TICKET_SHOULD_BE_PRINTED_SLUG', 'soll-das-ticket-ausgedruckt-werden');
define('EVENT_TICKET_TELEPHONE_SLUG', 'telefon');
define('DELIVERY_ORDER_EMAIL', 'it@rehorik.de');

// Categories
define('TICKET_CATEGORY_SLUG', 'ticket');
define('COFFEE_CATEGORY_SLUG', 'kaffee');
define('WINE_SPIRITS_CO_CATEGORY_SLUG', 'wein-spirits-co');
define('COFFEE_CREMA_CATEGORY_SLUG', 'crema');
define('COFFEE_ESPRESSO_CATEGORY_SLUG', 'espresso');
define('COFFEE_FILTERKAFFEE_CATEGORY_SLUG', 'filterkaffee');
define('DELIVERY_CATEGORY_SLUG', 'lieferservice');

// Attributes
define('DELIVERY_ATTRIBUTE_SLUG', 'pa_lieferservice');
define('STRENGTH_ATTRIBUTE_SLUG', 'pa_kaffee-staerke');
define('VARIETIES_ATTRIBUTE_SLUG', 'pa_kaffee-sorte');
define('GRAPE_VARIETY_ATTRIBUTE_SLUG', 'pa_rebsorte');
define('AUSBAU_ATTRIBUTE_SLUG', 'pa_ausbau');
define('FLAVOUR_ATTRIBUTE_SLUG', 'pa_kaffee-aromen');
define('FLAVOUR_VARIETY_ATTRIBUTE_SLUG', 'pa_kaffee-aromenvielfalt');
define('BEAN_COMPOSITION_ATTRIBUTE_SLUG', 'pa_bohnenkompositionen');
define('ORIGIN_COUNTRY_ATTRIBUTE_SLUG', 'pa_kaffee-herkunft');
define('REGION_ATTRIBUTE_SLUG', 'pa_region');
define('PRODUCT_OF_MONTH_ATTRIBUTE_SLUG', 'pa_product-of-month');
define('BIOSIGIL_ATTRIBUTE_SLUG', 'pa_biosiegel');
define('ALCOHOL_ATTRIBUTE_SLUG', 'pa_alkoholgehalt');
define('FILLING_QUANTITY_ATTRIBUTE_SLUG', 'pa_fuellmenge');
define('WINERY_ATTRIBUTE_SLUG', 'pa_weingut');
define('MANUFACTURER_ATTRIBUTE_SLUG', 'pa_hersteller');

// In $productAttributes array, slugs are prefixed by wordpress
define('ATTRIBUTE_SLUG_PREFIX', 'attribute_');

define('DELIVERY_SHIPPING_CLASS_SLUG', 'lieferservice');


$priority = 1000;

// In case of an child them use get stylesheet directory
$baseDir = get_stylesheet_directory();

require_once($baseDir . '/helper/category_helper.php');
require_once($baseDir . '/helper/shipping_helper.php');
require_once($baseDir . '/filter/product_tabs.php');


// Adds page title to the top on woocommerce pages
add_action('et_before_main_content', function () {
    if (is_woocommerce()) {
        $pageTitle = woocommerce_page_title(false);
        echo "<h1 class='page-title'>${pageTitle}</h1>";
    }
    if (is_cart() || is_checkout()) {
        $pageTitle = get_the_title();
        echo "<h1 class='page-title'>${pageTitle}</h1>";
    }
}, $priority);

/**
 * Adds class to body classes for shop page only.
 */
add_filter('body_class', function ($classes) {
    if (is_shop()) {
        return array_merge($classes, array('shop'));
    }

    return $classes;
});

/**
 * Removes breadcrumb.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

/**
 * Removes page title in content area.
 */
add_filter('woocommerce_show_page_title', function () {
    return false;
}, $priority);

add_action('wp_enqueue_scripts', function () {
    $assetsDir = get_stylesheet_directory_uri() . '/assets/';
    wp_enqueue_style('divi', $assetsDir . 'css/overwritten-divi.css', false, 1, 'all');
    wp_enqueue_style('shop', $assetsDir . 'css/shop.css', false, 1, 'all');
    wp_enqueue_script('hello', $assetsDir . 'js/product_variation_update.js', array('jquery'), 1, true);
}, $priority);

/**
 * Adds mobile nav.
 */
function et_add_child_mobile_navigation()
{
    if (is_customize_preview() || ('slide' !== et_get_option('header_style', 'left') && 'fullscreen' !== et_get_option('header_style', 'left'))) {
        echo '<div id="rehorik-mobile-nav"><div class="mobile_nav closed"><span class="mobile_menu_bar mobile_menu_bar_toggle"></span></div></div>';
    }
}
add_action('et_header_top', 'et_add_child_mobile_navigation');

/**
 * Adds price for one coup of coffee.
 */
add_action('render_one_cup_of_coffee_price', function ($product) {
    if (!isItCategory($product, COFFEE_CATEGORY_SLUG)) return;

    $woocommerceGzProduct = wc_gzd_get_product($product);

    $oneCupOfCoffeeInGrams = ONE_CUP_OF_COFFEE_IN_GRAMS;
    $unitName = $woocommerceGzProduct->get_unit();
    $unitBase = $woocommerceGzProduct->get_unit_base();
    $unitAmount = $unitName === "kg"
        ? 1000
        : ($unitName === "g" ? 1 : null);

    if ($unitAmount) {
        $multiplier = $oneCupOfCoffeeInGrams / $unitAmount;

        $unitPrice = empty($woocommerceGzProduct->get_unit_price())
            ? $woocommerceGzProduct->get_variation_unit_prices()
            : $woocommerceGzProduct->get_unit_price();

        $formattedPriceRange = "";

        if (is_numeric($unitPrice)) {
            $priceForOneCup = $unitPrice * $multiplier * $unitBase;
            $formattedPriceRange = wc_price($priceForOneCup);
        }

        if (is_array($unitPrice) && array_key_exists('price', $unitPrice)) {
            $min = min($unitPrice['price']);
            $max = max($unitPrice['price']);

            $priceForOneCupMin = $min * $multiplier * $unitBase;
            $priceForOneCupMax = $max * $multiplier * $unitBase;

            $formattedPriceRange = wc_format_price_range(
                $priceForOneCupMin,
                $priceForOneCupMax
            );
        }

        if (!empty($formattedPriceRange)) {
            echo "<div class='rehorik-cup-of-coffee-price-outer'>Eine Tasse Kaffee kostet nur <span class='rehorik-cup-of-coffee-price'>${formattedPriceRange}</span> (${oneCupOfCoffeeInGrams} g).</div>";
        }
    }
}, $priority, 1);

add_action('render_product_attribute_strength_flavour', function ($level, $class) {
    $level = strip_tags($level);

    echo '<div class="rehorik-product-strength-flavour-container">';
    for ($i = 1; $i <= MAX_COFFEE_STRENGTH_FLAVOUR_ATTRIBUTE; $i++) {
        if ($i <= (int)$level) {
            echo "<span class='rehorik-coffee-${class}-${i}-filled'></span>";
        } else {
            echo "<span class='rehorik-coffee-${class}-${i}'></span>";
        }
    }
    echo '</div>';
}, $priority, 2);

add_action('render_free_shipping_amount', function () {
    $minAmount = getFreeShippingAmount();

    echo '<span>' . $minAmount . ' &euro;</span>';
}, $priority, 1);

add_action('render_rest_amount_for_free_shipping', function () {
    $restAmount = getAmountTillFreeShipping();
    $restAmount = str_replace('.', ',', $restAmount);

    if ($restAmount > 0) {
        echo 'Nur noch <span>' . $restAmount . ' &euro;</span> bis zum kostenlosen Versand!';
    }
}, $priority, 1);

/**
 * @param $full_label
 * @param $method
 * @return string
 */
function remove_shipping_method_label($full_label, $method)
{
    $label = "";
    $has_cost = 0 < $method->cost;
    $hide_cost = !$has_cost && in_array($method->get_method_id(), array('free_shipping', 'local_pickup'), true);

    if ($has_cost && !$hide_cost) {
        if (WC()->cart->display_prices_including_tax()) {
            $label .= wc_price($method->cost + $method->get_shipping_tax());
            if ($method->get_shipping_tax() > 0 && !wc_prices_include_tax()) {
                $label .= ' <small>' . WC()->countries->inc_tax_or_vat() . '</small>';
            }
        } else {
            $label .= ': ' . wc_price($method->cost);
            if ($method->get_shipping_tax() > 0 && wc_prices_include_tax()) {
                $label .= ' <small>' . WC()->countries->ex_tax_or_vat() . '</small>';
            }
        }
    }
    return $label;
}
add_filter('woocommerce_cart_shipping_method_full_label', 'remove_shipping_method_label', 10, 2);

/**
 * Remove product category count.
 */
add_filter( 'woocommerce_subcategory_count_html', '__return_false' );

/**
 * Set delivery option to yes, if previous page was delivery category page
 */
function set_delivery_service_variation_default_value($args) {
    if ($args['attribute'] === DELIVERY_ATTRIBUTE_SLUG) {
        $referer = $_SERVER['HTTP_REFERER'];
        if (substr_count($referer, DELIVERY_CATEGORY_URL) === 1) {
            $args['selected'] = 'ja';
        }
    }

    return $args;
}
add_filter('woocommerce_dropdown_variation_attribute_options_args', 'set_delivery_service_variation_default_value', 10, 1);

/**
 * Add a custom email to the list of emails WooCommerce should load
 *
 * @since 0.1
 * @param array $email_classes available email classes
 * @return array filtered available email classes
 */
function split_order_woocommerce_email( $email_classes ) {
    require( 'includes/class-wc-delivery-order-email.php' );
    require( 'includes/class-wc-shipping-order-email.php' );
    $email_classes['WC_Delivery_Order_Email'] = new WC_Delivery_Order_Email();
    $email_classes['WC_Shipping_Order_Email'] = new WC_Shipping_Order_Email();
    unset($email_classes['WC_Email_New_Order']);

    add_option('rh_delivery_email', DELIVERY_ORDER_EMAIL);

    return $email_classes;
}
add_filter( 'woocommerce_email_classes', 'split_order_woocommerce_email', 10, 1 );