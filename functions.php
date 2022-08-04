<?php
show_admin_bar(true);

const ONE_CUP_OF_COFFEE_IN_GRAMS = 10;
const FREE_SHIPPING_AMOUNT = 69;
const MAX_DISPLAY_ORIGIN_COUNTRIES = 1;
const CONTACT_MAIL = 'kaffee@rehorik.de';
const IT_SUPPORT_EMAIL = 'it@rehorik.de';
const BARISTASTORE_EMAIL = 'baristastore@rehorik.de';
const EVENT_EMAIL = 'events@rehorik.de';
const DELIVERY_SHIPPING_METHOD = 'bike';
const FREE_DELIVERY_SHIPPING_METHOD = 'free_shipping_bike';

// Categories
const COFFEE_CATEGORY_SLUG = 'kaffee';
const WINE_CATEGORY_SLUG = 'wein';
const SPIRITS_CATEGORY_SLUG = 'spirits';
const COFFEE_CREMA_CATEGORY_SLUG = 'crema';
const COFFEE_ESPRESSO_CATEGORY_SLUG = 'espresso';
const COFFEE_FILTERKAFFEE_CATEGORY_SLUG = 'filterkaffee';
const MACHINE_CATEGORY_SLUG = 'maschinen-equipment';
const BLACK_AND_WINE = 'blackwine';
const TICKET_CATEGORY_SLUG = 'veranstaltungen';
const ONLINESHOP_CATEGORY_SLUG = 'onlineshop';
const VIRTUAL_EVENTS_CATEGORY_SLUG = 'virtuelle-events';
const VIRTUAL_EVENTS_CATEGORY_SLUGS = [
    VIRTUAL_EVENTS_CATEGORY_SLUG,
    'virtuelle-events-spirits',
    'virtuelle-events-wein'
];
const WINE_CATEGORY_SLUGS = [
    'rotwein',
    'likoer',
    'weisswein',
    'rose',
    'naturwein',
    'champagner-und-sekt'
];
const HIDE_CATEGORIES = [
    'delikatessen-onlineshop',
    'geschenke-gutscheine',
    'kaese-wurst'
];

// For Events which are only virtual online events
const ONLINE_META_KEY = 'Online';
const CANCELED_META_KEY = 'Abgesagt';

// Payment methods
const PAYMENT_METHOD_CASH = 'cod';
const PAYMENT_METHOD_DIRECT_TRANSFER = 'bacs';

// Pages
const STANDORTE_PAGE_ID = 26672;
const LOGIN_PAGE_ID = 667;
const AGB_PAGE_ID = 13644;
const WIDERRUFSBELEHRUNG_PAGE_ID = 682;
const IMPRESSUM_PAGE_ID = 681;
const DATENSCHUTZ_PAGE_ID = 680;

const PERMISSION_VIEW_VIEW_ATTENDEE_LIST = 'teilnehmerliste_bei_events_anschauen';

const DATE_FORMAT = 'd.m.Y H:i';

const TICKET_EVENT_DATE_START_META = '_event_timestamp_start';
const TICKET_EVENT_DATE_END_META = '_event_timestamp_end';

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
    wp_enqueue_style('shop', $assetsDir . 'css/shop.css', false, 1.97);
    wp_enqueue_script('product-variation-update', $assetsDir . 'js/product_variation_update.js', array('jquery'), 1, true);
    wp_enqueue_script('scroll', $assetsDir . 'js/scroll.js', false, 1, true);
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
