<?php
get_header();
get_template_part('templates/header/slider', null, ['items' => [
    [
        'claim' => 'EL RUBI - MEHR ALS EIN EDELSTEIN',
        'img'=> 'Produkt-Illustration-El-Rubi-header',
        'buttons' => [
            '/produkt/el-rubi' => 'Out now: Limited Edition Nr. 4 '
        ]
    ],
    [
        'claim' => 'Kaffeerösterei seit 1928',
        'img'=> 'startseite-header-kaffee',
        'buttons' => [
            get_term_link(get_term_by('slug', COFFEE_CATEGORY_SLUG, 'product_cat'),
                'product_cat') => 'Zum Kaffee',
            get_page_link(ROESTEREI_PAGE_ID) => 'Unser Kugelröster'
        ]
    ],
    [
        'claim' => 'TRADITION, QUALITÄT & LEIDENSCHAFT',
        'img'=> 'startseite-header-roesterei',
        'buttons' => [
            get_term_link(get_term_by('slug', COFFEE_FILTERKAFFEE_CATEGORY_SLUG, 'product_cat'),
                'product_cat') => 'Hier gibts Filterkaffee',
            get_term_link(get_term_by('slug', COFFEE_ESPRESSO_CATEGORY_SLUG, 'product_cat'),
                'product_cat') => 'Und hier Espresso'
        ]
    ],
    [
        'claim' => 'WIR KÖNNEN AUCH ANDERS',
        'img'=> 'startseite-header-wein',
        'buttons' => [
            get_term_link(get_term_by('slug', WINE_CATEGORY_SLUG, 'product_cat'),
                'product_cat') => 'Zur Weinauswahl',
            get_term_link(get_term_by('slug', SPIRITS_CATEGORY_SLUG, 'product_cat'),
                'product_cat') => 'Und Spirituosen'
        ]
    ]
]]);
?>
<a id="rehorik-logo" href="<?php echo get_home_url(); ?>"></a>
<div class="page-title-outer">
    <div class='page-title'><h1>Shop</h1></div>
    <div class="rehorik-hint">
        <input type="checkbox">
        <div>Aktuelle Informationen</div>
        <div>
            <div>
                Endlich ist es soweit: die neuen Veranstaltungstermine sind online. Feiert, genießt & lernt mit uns.
                <br>
                Hier geht's zu den aktuellen <a href="/produkt-kategorie/veranstaltungen/">Events</a>.
            </div>
            <hr>
            <div>
                Aufgrund von Lieferproblemen beim Rohkaffe kommt es bei einigen Kaffeesorten zu einer
                Versandverzögerung.
                Wir bitten um Verständnis.
            </div>
        </div>
    </div>
</div>
<iframe src="https://snazzymaps.com/embed/383637" width="100%" height="600px" style="border:none;"></iframe>
<ul>
<?php
// Retrieve the next 5 upcoming events
$events = tribe_get_events( [
    'posts_per_page' => 5,
    'start_date'     => 'now',
] );
foreach ($events as $event) {
    /** @var WP_Post $event */
    echo sprintf('<li>%s - %s</li>', $event->post_title, $event->event_date);
}
?>
</ul>
<div class="container hint-margin-top">
    <ul class="rehorik-products products">
        <?php
            $product_categories = getShopFrontPageCategories();
            foreach ($product_categories as $category) {
                wc_get_template(
                    'content-product_cat.php',
                    [
                        'category' => $category,
                    ]
                );
            }
        ?>
    </ul>
</div>
<?php
get_template_part('templates/best-selling-products');
get_footer();
?>
