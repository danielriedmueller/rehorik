<?php get_header(); ?>
<ul id="slider">
    <?php get_template_part('templates/frontpage-header-item', null, [
            'id' => 5,
            'claim' => 'Heute ist Weltschlaftag!',
            'text' => '
Kaffee kann Euren Schlaf durchaus begünstigen - und weil das so ist, bekommt Ihr am Weltschlaftag am 18. März 10% auf alle Kaffees in unserem Onlineshop! Nicht schläfrig sein ;)
',
            'buttons' => [
                '/produkt-kategorie/onlineshop/kaffee/' => 'Rabattcode: SCHLAF10',
                'https://www.instagram.com/p/CbM8jZiKbD1/' => 'Julian auf Instagram'
            ]
    ]) ?>
    <?php get_template_part('templates/frontpage-header-item', null, [
        'id' => 4,
        'claim' => 'EL RUBI - MEHR ALS EIN EDELSTEIN',
        'buttons' => [
            '/produkt/el-rubi' => 'Out now: Limited Edition Nr. 4 '
        ]
    ]) ?>
    <?php get_template_part('templates/frontpage-header-item', null, [
        'id' => 1,
        'claim' => 'Kaffeerösterei seit 1928',
        'buttons' => [
            get_term_link(get_term_by('slug', COFFEE_CATEGORY_SLUG, 'product_cat'),
                    'product_cat') => 'Zum Kaffee',
            get_page_link(ROESTEREI_PAGE_ID) => 'Unser Kugelröster'
        ]
    ]) ?>
    <?php get_template_part('templates/frontpage-header-item', null, [
        'id' => 2,
        'claim' => 'TRADITION, QUALITÄT & LEIDENSCHAFT',
        'buttons' => [
            get_term_link(get_term_by('slug', COFFEE_FILTERKAFFEE_CATEGORY_SLUG, 'product_cat'),
                'product_cat') => 'Hier gibts Filterkaffee',
            get_term_link(get_term_by('slug', COFFEE_ESPRESSO_CATEGORY_SLUG, 'product_cat'),
                'product_cat') => 'Und hier Espresso'
        ]
    ]) ?>
    <?php get_template_part('templates/frontpage-header-item', null, [
        'id' => 3,
        'claim' => 'WIR KÖNNEN AUCH WEIN',
        'buttons' => [
            get_term_link(get_term_by('slug', WINE_SPIRITS_CO_CATEGORY_SLUG, 'product_cat'),
                'product_cat') => 'Zur Weinauswahl',
            get_term_link(get_term_by('slug', WINE_SPIRITS_CO_CATEGORY_SLUG, 'product_cat'),
                'product_cat') => 'Und Spirituosen'
        ]
    ]) ?>
</ul>
<div id="tns-controls-container">
    <button></button>
    <button></button>
</div>
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
