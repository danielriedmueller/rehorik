<?php
show_admin_bar(true);

define('ONE_CUP_OF_COFFEE_IN_GRAMS', 10);
define('FREE_SHIPPING_AMOUNT', 49);
define('MAX_DISPLAY_ORIGIN_COUNTRIES', 1);
define('DELIVERY_CATEGORY_URL', 'produkt-kategorie/lieferservice');
define('EVENT_TICKET_SHOULD_BE_PRINTED_SLUG', 'soll-das-ticket-ausgedruckt-werden');
define('EVENT_TICKET_TELEPHONE_SLUG', 'telefon');
define('CONTACT_MAIL', 'kaffee@rehorik.de');
define('IT_SUPPORT_EMAIL', 'it@rehorik.de');
define('BARISTASTORE_EMAIL', 'baristastore@rehorik.de');
define('EVENT_EMAIL', 'events@rehorik.de');
define('DELIVERY_SHIPPING_METHOD', 'bike');
define('STANDARD_SHIPPING_METHOD', 'flat_rate');
define('FREE_DELIVERY_SHIPPING_METHOD', 'free_shipping_bike');
define('FREE_STANDARD_SHIPPING_METHOD', 'free_shipping');

// Categories
define('COFFEE_CATEGORY_SLUG', 'kaffee');
define('WINE_CATEGORY_SLUG', 'wein');
define('SPIRITS_CATEGORY_SLUG', 'spirits');
define('COFFEE_CREMA_CATEGORY_SLUG', 'crema');
define('COFFEE_ESPRESSO_CATEGORY_SLUG', 'espresso');
define('COFFEE_FILTERKAFFEE_CATEGORY_SLUG', 'filterkaffee');
define('DELI_CATEGORY_SLUG', 'delikatessen-onlineshop');
define('GIFTS_CATEGORY_SLUG', 'geschenke');
define('MACHINE_CATEGORY_SLUG', 'maschinen-equipment');
define('BLACK_AND_WINE', 'blackwine');
define('OSTERN_CATEGORY_SLUG', 'ostern');
define('TICKET_CATEGORY_SLUG', 'veranstaltungen');
define('ONLINESHOP_CATEGORY_SLUG', 'onlineshop');
define('VIRTUAL_EVENTS_CATEGORY_SLUG', 'virtuelle-events');
define('VIRTUAL_EVENTS_CATEGORY_SLUGS', [
    VIRTUAL_EVENTS_CATEGORY_SLUG,
    'virtuelle-events-spirits',
    'virtuelle-events-wein'
]);
define('WINE_CATEGORY_SLUGS', [
    'rotwein',
    'likoer',
    'weisswein',
    'rose',
    'naturwein',
    'champagner-und-sekt'
]);
define('HIDE_CATEGORIES', [
    'delikatessen-onlineshop',
    'geschenke-gutscheine',
    'kaese-wurst'
]);

// For Events which are only virtual online events
define('ONLINE_META_KEY', 'Online');
define('CANCELED_META_KEY', 'Abgesagt');

// Payment methods
define('PAYMENT_METHOD_CASH', 'cod');
define('PAYMENT_METHOD_DIRECT_TRANSFER', 'bacs');

// Pages
define('STANDORTE_PAGE_ID', 26672);
define('ROESTEREI_PAGE_ID', 40);
define('LOGIN_PAGE_ID', 667);
define('AGB_PAGE_ID', 13644);
define('WIDERRUFSBELEHRUNG_PAGE_ID', 682);
define('IMPRESSUM_PAGE_ID', 681);
define('DATENSCHUTZ_PAGE_ID', 680);

define('PERMISSION_VIEW_VIEW_ATTENDEE_LIST', 'teilnehmerliste_bei_events_anschauen');

define('TICKET_EVENT_DATE_START_META', '_event_date_start');
define('TICKET_EVENT_DATE_END_META', '_event_date_end');
define('TICKET_EVENT_TIME_START_META', '_event_time_start');
define('TICKET_EVENT_TIME_END_META', '_event_time_end');


$priority = 1000;

// In case of an child them use get stylesheet directory
$baseDir = get_stylesheet_directory();

require_once($baseDir . '/includes/class-wc-shipping-bike.php');
require_once($baseDir . '/includes/class-wc-shipping-free-shipping-bike.php');
require_once($baseDir . '/includes/class-tribe-tickets-plus-woocommerce-main.php');
require_once($baseDir . '/helper/category_helper.php');
require_once($baseDir . '/helper/shipping_helper.php');
require_once($baseDir . '/helper/woocommerce_functions.php');
require_once($baseDir . '/hooks/woocommerce.php');
require_once($baseDir . '/filter/shop.php');
require_once($baseDir . '/filter/categories.php');
require_once($baseDir . '/filter/product_view.php');
require_once($baseDir . '/filter/sitemap.php');
require_once($baseDir . '/actions/woocommerce.php');
require_once($baseDir . '/actions/rehorik.php');
require_once($baseDir . '/actions/events.php');

add_action('wp_enqueue_scripts', function () {
    $assetsDir = get_stylesheet_directory_uri() . '/assets/';
    wp_enqueue_style('shop', $assetsDir . 'css/shop.css', false, 1.97, 'all');
    wp_enqueue_script('product-variation-update', $assetsDir . 'js/product_variation_update.js', array('jquery'), 1, true);
    wp_enqueue_script('social-media-icons-scroll', $assetsDir . 'js/social_media_icons_scroll.js', false, 1, true);
    wp_enqueue_script('product-cat-video', $assetsDir . 'js/product_cat_video.js', false, 1, true);
    wp_enqueue_style('slider-css', $assetsDir . 'css/tiny-slider.css', false, 1, 'all');
    wp_enqueue_script('tiny-slider-js', 'https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js', null, 1, true);
    wp_enqueue_script('slider-js', $assetsDir . 'js/tiny_slider.js', null, 1, true);

    if (is_front_page()) {
        wp_enqueue_script('orderbird-chooser', $assetsDir . 'js/orderbird_chooser.js', false, 1, true);
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
        'before_widget' => '<div class="rehorik-product-search-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ]);
}