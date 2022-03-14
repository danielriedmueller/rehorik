<?php
show_admin_bar(true);

require_once('sig_functions.php');

define('ONE_CUP_OF_COFFEE_IN_GRAMS', 10);
define('FREE_SHIPPING_AMOUNT', 49);
define('MAX_COFFEE_STRENGTH_FLAVOUR_ATTRIBUTE', 6);
define('MAX_DISPLAY_ORIGIN_COUNTRIES', 1);
define('DELIVERY_CATEGORY_URL', 'produkt-kategorie/lieferservice');
define('EVENT_TICKET_SHOULD_BE_PRINTED_SLUG', 'soll-das-ticket-ausgedruckt-werden');
define('EVENT_TICKET_TELEPHONE_SLUG', 'telefon');
define('DELIVERY_ORDER_EMAIL', 'kaffee@rehorik.de');
define('SHIPPING_ORDER_EMAIL', 'kaffee@rehorik.de');
define('IT_SUPPORT_EMAIL', 'it@rehorik.de');
define('BARISTASTORE_EMAIL', 'baristastore@rehorik.de');
define('EVENT_EMAIL', 'events@rehorik.de');
define('DELIVERY_SHIPPING_METHOD', 'bike');
define('STANDARD_SHIPPING_METHOD', 'flat_rate');
define('FREE_DELIVERY_SHIPPING_METHOD', 'free_shipping_bike');
define('FREE_STANDARD_SHIPPING_METHOD', 'free_shipping');

// Categories
define('COFFEE_CATEGORY_SLUG', 'kaffee');
define('WINE_SPIRITS_CO_CATEGORY_SLUG', 'wein-spirits-co');
define('COFFEE_CREMA_CATEGORY_SLUG', 'crema');
define('COFFEE_ESPRESSO_CATEGORY_SLUG', 'espresso');
define('COFFEE_FILTERKAFFEE_CATEGORY_SLUG', 'filterkaffee');
define('DELI_CATEGORY_SLUG', 'delikatessen-onlineshop');
define('GIFTS_CATEGORY_SLUG', 'geschenke');
define('MACHINE_CATEGORY_SLUG', 'maschinen-equipment');
define('TICKET_CATEGORY_SLUG', 'veranstaltungen');
define('ONLINESHOP_CATEGORY_SLUG', 'onlineshop');
define('VIRTUAL_EVENTS_CATEGORY_SLUG', 'virtuelle-events');
define('WINE_CATEGORY_SLUGS', [
    'rotwein',
    'likoer',
    'weisswein-rose',
    'champagner-und-sekt'
]);

// Attributes
define('STRENGTH_ATTRIBUTE_SLUG', 'pa_staerke');
define('VARIETIES_ATTRIBUTE_SLUG', 'pa_sorte');
define('GRAPE_VARIETY_ATTRIBUTE_SLUG', 'pa_rebsorte');
define('AUSBAU_ATTRIBUTE_SLUG', 'pa_ausbau');
define('HERSTELLUNG_ATTRIBUTE_SLUG', 'pa_herstellung');
define('MILCHART_ATTRIBUTE_SLUG', 'pa_milchart');
define('FETT_ATTRIBUTE_SLUG', 'pa_fett');
define('FLAVOUR_ATTRIBUTE_SLUG', 'pa_aromen');
define('FLAVOUR_VARIETY_ATTRIBUTE_SLUG', 'pa_aromenvielfalt');
define('BEAN_COMPOSITION_ATTRIBUTE_SLUG', 'pa_bohnenkompositionen');
define('ORIGIN_COUNTRY_ATTRIBUTE_SLUG', 'pa_herkunft');
define('REGION_ATTRIBUTE_SLUG', 'pa_region');
define('PRODUCT_OF_MONTH_ATTRIBUTE_SLUG', 'pa_product-of-month');
define('BIOSIGIL_ATTRIBUTE_SLUG', 'pa_biosiegel');

define('ALCOHOL_ATTRIBUTE_SLUG', 'pa_alkoholgehalt');
define('WEIGHT_ATTRIBUTE_SLUG', 'pa_gewicht');
define('FILLING_QUANTITY_ATTRIBUTE_SLUG', 'pa_fuellmenge');
define('WINERY_ATTRIBUTE_SLUG', 'pa_weingut');
define('MANUFACTURER_ATTRIBUTE_SLUG', 'pa_hersteller');
define('GIFT_CONTENT_ATTRIBUTE_SLUG', 'pa_inhalt-praesentkarton');

// For Events which are only virtual online events
define('ONLINE_META_KEY', 'Online');
define('CANCELED_META_KEY', 'Abgesagt');

// Payment methods
define('PAYMENT_METHOD_CASH', 'cod');
define('PAYMENT_METHOD_DIRECT_TRANSFER', 'bacs');

// In $productAttributes array, slugs are prefixed by wordpress
define('ATTRIBUTE_SLUG_PREFIX', 'attribute_');

// All product attributes that appear in information tab on product detail page
define('INFORMATION_TAB_ATTRIBUTES', [
    ORIGIN_COUNTRY_ATTRIBUTE_SLUG,
    VARIETIES_ATTRIBUTE_SLUG,
    FLAVOUR_ATTRIBUTE_SLUG,
    FETT_ATTRIBUTE_SLUG,
]);

// Pages
define('NEUE_ROESTEREI_PAGE_ID', 21830);
define('ROESTEREI_PAGE_ID', 40);
define('CAFE_190_PAGE_ID', 44);
define('LOGIN_PAGE_ID', 667);
define('KONTAKT_PAGE_ID', 121);
define('KARRIERE_PAGE_ID', 119);
define('AGB_PAGE_ID', 13644);
define('WIDERRUFSBELEHRUNG_PAGE_ID', 682);
define('IMPRESSUM_PAGE_ID', 681);
define('DATENSCHUTZ_PAGE_ID', 680);
define('STAMMHAUS_PAGE_ID', 2);
define('OPENING_HOURS_PAGE_ID', 11242);
define('DEZ_PAGE_ID', 489);
define('WEINGALERIE_PAGE_ID', 487);
define('BARISTASTORE_PAGE_ID', 1535);

define('PERMISSION_VIEW_VIEW_ATTENDEE_LIST', 'teilnehmerliste_bei_events_anschauen');

$priority = 1000;

// In case of an child them use get stylesheet directory
$baseDir = get_stylesheet_directory();

require_once($baseDir . '/includes/class-wc-shipping-bike.php');
require_once($baseDir . '/includes/class-wc-shipping-free-shipping-bike.php');
require_once($baseDir . '/helper/category_helper.php');
require_once($baseDir . '/helper/shipping_helper.php');
require_once($baseDir . '/helper/woocommerce_functions.php');
require_once($baseDir . '/hooks/events.php');
require_once($baseDir . '/hooks/woocommerce.php');
require_once($baseDir . '/filter/product_tabs.php');
require_once($baseDir . '/filter/shop.php');
require_once($baseDir . '/filter/categories.php');
require_once($baseDir . '/actions/divi.php');
require_once($baseDir . '/actions/woocommerce.php');
require_once($baseDir . '/actions/rehorik.php');

add_action('wp_enqueue_scripts', function () {
    $assetsDir = get_stylesheet_directory_uri() . '/assets/';
    wp_enqueue_style('divi', $assetsDir . 'css/overwritten-divi.css', false, 1.1, 'all');
    wp_enqueue_style('shop', $assetsDir . 'css/shop.css', false, 1.97, 'all');
    wp_enqueue_script('product-variation-update', $assetsDir . 'js/product_variation_update.js', array('jquery'), 1, true);
    wp_enqueue_script('social-media-icons-scroll', $assetsDir . 'js/social_media_icons_scroll.js', false, 1, true);
    wp_enqueue_script('product-cat-video', $assetsDir . 'js/product_cat_video.js', false, 3, true);

    if (is_front_page()) {
        wp_enqueue_style('slider-css', $assetsDir . 'css/tiny-slider.css', false, 1, 'all');
        wp_enqueue_script('tiny-slider-js', 'https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js', null, 1, true);
        wp_enqueue_script('slider-js', $assetsDir . 'js/tiny_slider.js', null, 1, true);
    }
});

add_action('init', function() {
    register_nav_menus([
        'main'   => 'Hauptmenü'
    ]);

    /*
     * Temporarily Disabled
     *
    if (!wp_next_scheduled( 'rh_past_events_cron_hook') ) {
        wp_schedule_event(time(), 'twicedaily', 'rh_past_events_cron_hook');
    }
    */
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
