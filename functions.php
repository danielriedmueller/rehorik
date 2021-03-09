<?php
show_admin_bar(false);

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
define('ONLINESHOP_CATEGORY_SLUG', 'onlineshop');
define('WINE_CATEGORY_SLUGS', [
    'rotwein',
    'likoer',
    'weisswein-rose',
    'champagner-und-sekt'
]);

// Attributes
define('DELIVERY_ATTRIBUTE_SLUG', 'pa_lieferservice');
define('STRENGTH_ATTRIBUTE_SLUG', 'pa_kaffee-staerke');
define('VARIETIES_ATTRIBUTE_SLUG', 'pa_kaffee-sorte');
define('GRAPE_VARIETY_ATTRIBUTE_SLUG', 'pa_rebsorte');
define('AUSBAU_ATTRIBUTE_SLUG', 'pa_ausbau');
define('HERSTELLUNG_ATTRIBUTE_SLUG', 'pa_herstellung');
define('MILCHART_ATTRIBUTE_SLUG', 'pa_milchart');
define('FETT_ATTRIBUTE_SLUG', 'pa_fett');
define('FLAVOUR_ATTRIBUTE_SLUG', 'pa_kaffee-aromen');
define('FLAVOUR_VARIETY_ATTRIBUTE_SLUG', 'pa_kaffee-aromenvielfalt');
define('BEAN_COMPOSITION_ATTRIBUTE_SLUG', 'pa_bohnenkompositionen');
define('ORIGIN_COUNTRY_ATTRIBUTE_SLUG', 'pa_kaffee-herkunft');
define('REGION_ATTRIBUTE_SLUG', 'pa_region');
define('PRODUCT_OF_MONTH_ATTRIBUTE_SLUG', 'pa_product-of-month');
define('BIOSIGIL_ATTRIBUTE_SLUG', 'pa_biosiegel');
define('ALCOHOL_ATTRIBUTE_SLUG', 'pa_alkoholgehalt');
define('WEIGHT_ATTRIBUTE_SLUG', 'pa_gewicht');
define('FILLING_QUANTITY_ATTRIBUTE_SLUG', 'pa_fuellmenge');
define('WINERY_ATTRIBUTE_SLUG', 'pa_weingut');
define('MANUFACTURER_ATTRIBUTE_SLUG', 'pa_hersteller');
define('GIFT_CONTENT_ATTRIBUTE_SLUG', 'pa_inhalt-praesentkarton');

// In $productAttributes array, slugs are prefixed by wordpress
define('ATTRIBUTE_SLUG_PREFIX', 'attribute_');

define('DELIVERY_SHIPPING_CLASS_SLUG', 'lieferservice');

// All product attributes that appear in information tab on product detail page
define('INFORMATION_TAB_ATTRIBUTES', [
    ORIGIN_COUNTRY_ATTRIBUTE_SLUG,
    VARIETIES_ATTRIBUTE_SLUG,
    FLAVOUR_ATTRIBUTE_SLUG,
    FETT_ATTRIBUTE_SLUG,
]);

$priority = 1000;

// In case of an child them use get stylesheet directory
$baseDir = get_stylesheet_directory();

require_once($baseDir . '/helper/category_helper.php');
require_once($baseDir . '/helper/shipping_helper.php');
require_once($baseDir . '/helper/woocommerce_functions.php');
require_once($baseDir . '/filter/product_tabs.php');
require_once($baseDir . '/filter/shop.php');
require_once($baseDir . '/filter/categories.php');
require_once($baseDir . '/filter/emails.php');
require_once($baseDir . '/actions/divi.php');
require_once($baseDir . '/actions/woocommerce.php');
require_once($baseDir . '/actions/rehorik.php');

add_action('wp_enqueue_scripts', function () {
    $assetsDir = get_stylesheet_directory_uri() . '/assets/';
    wp_enqueue_style('divi', $assetsDir . 'css/overwritten-divi.css', false, 1, 'all');
    wp_enqueue_style('shop', $assetsDir . 'css/shop.css', false, 1.1, 'all');
    wp_enqueue_script('product-variation-update', $assetsDir . 'js/product_variation_update.js', array('jquery'), 1, true);
    wp_enqueue_script('social-media-icons-scroll', $assetsDir . 'js/social_media_icons_scroll.js', false, 1, true);

    // Slider only on delivery category page
    if (is_product_category('lieferservice') || is_front_page()) {
        wp_enqueue_style('slider-css', $assetsDir . 'css/tiny-slider.css', false, 1, 'all');
        wp_enqueue_script('tiny-slider-js', 'https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js', null, 1, true);
        wp_enqueue_script('slider-js', $assetsDir . 'js/tiny_slider.js', null, 1, true);
    }
});

add_action('init', function() {
    register_nav_menus([
        'main'   => 'Hauptmenü'
    ]);
});

/**
 * Adds search widget area
 */
if (function_exists('register_sidebar')) {
    register_sidebar([
        'id' => 'productsearch',
        'name' => 'Produktsuche',
        'before_widget' => '<div class = "rehorik-product-search-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ]);
}