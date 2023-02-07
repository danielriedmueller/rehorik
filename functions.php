<?php
show_admin_bar(true);

const BAYERNWERK_COUPON_CODE = 'bayernwerkxmas22';

const ONE_CUP_OF_COFFEE_IN_GRAMS = 10;
const FREE_SHIPPING_AMOUNT = 69;
const MAX_DISPLAY_ORIGIN_COUNTRIES = 1;
const DEFAULT_MAX_PRODUCT_STOCK_INPUT = 100;
const CONTACT_MAIL = 'kaffee@rehorik.de';
const CONTACT_PHONE = '0941 / 788 353 0';
const IT_SUPPORT_EMAIL = 'it@rehorik.de';
const BARISTASTORE_EMAIL = 'baristastore@rehorik.de';
const EVENT_EMAIL = 'events@rehorik.de';

// PDFs
const MENU_190 = '/speisekarte/Speisekarte190.pdf';
const MENU_STRAUBINGER = '/speisekarte/SpeisekarteStraubinger.pdf';
const INGREDIENT_AND_NUTRITION_INFORMATION = '/Rehorik_Geschenkkoerbe_Allergene_und_Inhaltsstoffe_2022.pdf';

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
const GIFTS_CATEGORY_SLUG = 'geschenke';
const COUPON_CATEGORY_SLUG = 'gutscheine';
const ONLINESHOP_CATEGORY_SLUG = 'onlineshop';
const VIRTUAL_EVENTS_CATEGORY_SLUG = 'virtuelle-events';
const VIRTUAL_EVENTS_CATEGORY_SLUGS = [
    VIRTUAL_EVENTS_CATEGORY_SLUG,
    'virtuelle-events-spirits',
    'virtuelle-events-wein',
];
const WINE_CATEGORY_SLUGS = [
    'rotwein',
    'likoer',
    'weisswein',
    'rose',
    'naturwein',
    'champagner-und-sekt',
];
const HIDE_CATEGORIES = [
    746, // 'delikatessen-onlineshop'
    513, // 'kaese-wurst'
];

// Attributes
const STRENGTH_ATTRIBUTE_SLUG = 'pa_staerke';
const VARIETIES_ATTRIBUTE_SLUG = 'pa_sorte';
const GRAPE_VARIETY_ATTRIBUTE_SLUG = 'pa_rebsorte';
const AUSBAU_ATTRIBUTE_SLUG = 'pa_ausbau';
const HERSTELLUNG_ATTRIBUTE_SLUG = 'pa_herstellung';
const MILCHART_ATTRIBUTE_SLUG = 'pa_milchart';
const FLAVOUR_ATTRIBUTE_SLUG = 'pa_aromen';
const FLAVOUR_VARIETY_ATTRIBUTE_SLUG = 'pa_aromenvielfalt';
const BEAN_COMPOSITION_ATTRIBUTE_SLUG = 'pa_bohnenkompositionen';
const ORIGIN_COUNTRY_ATTRIBUTE_SLUG = 'pa_herkunft';
const REGION_ATTRIBUTE_SLUG = 'pa_region';
const GUETESIEGEL_ATTRIBUTE_SLUG = 'pa_guetesiegel';
const BIOSIGIL_ATTRIBUTE_SLUG = 'pa_biosiegel';
const ALCOHOL_ATTRIBUTE_SLUG = 'pa_alkoholgehalt';
const VINTAGE_ATTRIBUTE_SLUG = 'pa_jahrgang';
const WEIGHT_SLUG = 'weight';
const WEIGHT_ATTRIBUTE_SLUG = 'pa_gewicht';
const FILLING_QUANTITY_ATTRIBUTE_SLUG = 'pa_fuellmenge';
const WINERY_ATTRIBUTE_SLUG = 'pa_weingut';
const GOES_WITH_ATTRIBUTE_SLUG = 'pa_passt-zu';
const QUALITY_NAME_ATTRIBUTE_SLUG = 'pa_qualitaetsbezeichnung';
const MANUFACTURER_ATTRIBUTE_SLUG = 'pa_hersteller';
const GIFT_CONTENT_ATTRIBUTE_SLUG = 'pa_inhalt-praesentkarton';
const SIZE_ATTRIBUTE_SLUG = 'pa_groesse';
const TECHNICAL_DETAILS_ATTRIBUTE_SLUG = 'pa_technische-daten';

// In $productAttributes array, slugs are prefixed by wordpress
const ATTRIBUTE_SLUG_PREFIX = 'attribute_';

// For Events which are only virtual online events
const ONLINE_META_KEY = 'Online';
const CANCELED_META_KEY = 'Abgesagt';

// Generated coupon code saved in order item
const ORDER_ITEM_COUPON_CODE = 'order_item_coupon_code';

// Payment methods
const PAYMENT_METHOD_CASH = 'cod';
const PAYMENT_METHOD_DIRECT_TRANSFER = 'bacs';

// Default shipping
const SHIPPING_DURATION_MESSAGE = '3 - 5 Werktage';

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

$baseDir = get_stylesheet_directory();

require_once($baseDir . '/includes/class-tribe-tickets-plus-woocommerce-main.php');
require_once($baseDir . '/includes/class-reh-online-coupon.php');
require_once($baseDir . '/includes/class-reh-api-products.php');
require_once($baseDir . '/includes/class-reh-mini-cart.php');
require_once($baseDir . '/includes/class-reh-product-feed.php');
require_once($baseDir . '/helper/category_helper.php');
require_once($baseDir . '/helper/shipping_helper.php');
require_once($baseDir . '/helper/woocommerce_functions.php');
require_once($baseDir . '/hooks/woocommerce.php');
require_once($baseDir . '/filter/shop.php');
require_once($baseDir . '/filter/categories.php');
require_once($baseDir . '/filter/product_view.php');
require_once($baseDir . '/filter/sitemap.php');
require_once($baseDir . '/filter/payment_gateways.php');
require_once($baseDir . '/filter/order_completed_email.php');
require_once($baseDir . '/actions/woocommerce.php');
require_once($baseDir . '/actions/rehorik.php');
require_once($baseDir . '/actions/events.php');
require_once($baseDir . '/actions/api/endpoints.php');

add_action('wp_enqueue_scripts', function () {
    $assetsDir = get_stylesheet_directory_uri() . '/assets/';
    wp_enqueue_style('shop', $assetsDir . 'css/shop.css', false, 1.97);
    wp_enqueue_script('mobile-menu', $assetsDir . 'js/mobile_menu.js', [], 1, true);
    wp_enqueue_script('product-variation-update', $assetsDir . 'js/product_variation_update.js', ['jquery'], 1, true);
    wp_enqueue_script('overwrite-woocommerce', $assetsDir . 'js/overwrite_woocommerce.js', ['jquery'], 1, true);
    wp_enqueue_script('product-variation-update', $assetsDir . 'js/product_variation_update.js', ['jquery'], 1, true);
    wp_enqueue_script('scroll', $assetsDir . 'js/scroll.js', false, 1, true);
    wp_enqueue_script('product-cat-video', $assetsDir . 'js/product_cat_video.js', false, 1, true);
    wp_enqueue_style('slider-css', $assetsDir . 'css/tiny-slider.css', false, 1, 'all');
    wp_enqueue_script('tiny-slider-js', $assetsDir . 'js/res/tiny-slider-min-2.9.4.js', null, 1, true);
    wp_enqueue_script('slider-js', $assetsDir . 'js/slider.js', null, 1, true);
    wp_enqueue_script('mini-cart', $assetsDir . 'js/mini_cart.js', ['jquery'], 1, true);

    wp_enqueue_script('cart-ajax', $assetsDir . 'js/cart_ajax.js', ['jquery'], 1, true);
    wp_localize_script( 'cart-ajax', 'settings', [
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'add_nonce' => wp_create_nonce( 'rehorik-add-to-cart' ),
        'update_nonce' => wp_create_nonce( 'rehorik-update-cart' ),
    ]);

    if (is_front_page()) {
        wp_enqueue_script('orderbird-chooser', $assetsDir . 'js/orderbird_chooser.js', ['jquery'], 1, true);
    }
});

add_action('init', function () {
    register_nav_menus([
        'main' => 'Hauptmenü'
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
