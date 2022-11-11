<?php
get_template_part('templates/header/head', null, ['slider' => [
    [
        'claim' => 'Es Weinachtet!',
        'img' => 'header-geschenkkoerbe',
        'buttons' => [
            '/produkt-kategorie/veranstaltungen/weinachtsmarkt/' => 'Weinachtsmarkt am 26.11',
            '/produkt-kategorie/onlineshop/geschenke-gutscheine/geschenke/' => 'Einfach für jeden Anlass',
        ],
    ],
    [
        'claim' => 'TRADITION, QUALITÄT & LEIDENSCHAFT',
        'img'=> 'startseite-header-roesterei',
        'buttons' => [
            '/tradition' => 'Tradition',
            '/standorte' => 'Standorte'
        ]
    ],
    [
        'claim' => 'Kaffeerösterei seit 1928',
        'img'=> 'startseite-header-kaffee',
        'buttons' => [
            get_term_link(get_term_by('slug', COFFEE_CATEGORY_SLUG, 'product_cat'),
                'product_cat') => 'Zum Kaffee'
        ]
    ]
]]);
get_template_part('templates/hint');
get_template_part('templates/featured/slider')
?>
<div class="marketing-banner weinachtsmarkt">
    <div class="container">
        <div class="marketing-banner-text">
            <h2>Komm zum Rehorik <span>Wein</span>achtsmarkt!<br>Am 26.11. / 13 Uhr, am Brixener Hof 6, 93047 Regensburg.<br>Was wirds geben?</h2>
            <a class="learn-more" href="/produkt-kategorie/veranstaltungen/weinachtsmarkt/">erfahre mehr</a>
        </div>
    </div>
</div>
<div class="container">
    <ul class="rehorik-products products">
        <li class="product-category product">
            <?php get_template_part('templates/orderbird-chooser'); ?>
        </li>
        <?php
        $product_categories = getShopFrontPageCategories();
        wc_get_template(
            'content-product_cat.php',
            [
                'category' => array_pop($product_categories),
            ]
        );
        ?>
        <li class="product-category product">
            <?php get_template_part('templates/coffee-chooser'); ?>
        </li>
        <?php
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
<div class="marketing-banner section-spacing-bottom">
    <div class="container">
        <div class="marketing-banner-text">
            <h2>Wir sind umtriebig, vielfältig und kreativ - voller Mut und Energie, etwas Besonderes zu erschaffen. Einen Raum der Inspiration und Lebensfreude.
                Wir verbinden Menschen durch Genuss,
                wir leben Leidenschaft für hochwertige Produkte. Und das seit Generationen.</h2>
            <a class="learn-more" href="/tradition">erfahre mehr</a>
        </div>
    </div>
</div>
<?php
get_footer();
?>
