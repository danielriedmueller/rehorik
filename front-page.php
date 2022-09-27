<?php
get_template_part('templates/header/head', null, ['slider' => [
    [
        'claim' => 'Wir leben, lieben und schätzen die Kaffeebohne!',
        'primary' => true,
        'img'=> 'header-tag-des-kaffees',
        'buttons' => [
            '/produkt-kategorie/onlineshop/kaffee/' => '10% Rabatt am Tag des Kaffees'
        ]
    ],
    [
        'claim' => 'Wir feiern den Kaffee! Feiert mit!',
        'primary' => true,
        'img'=> 'header-tag-des-kaffees-2',
        'buttons' => [
            '/produkt-kategorie/onlineshop/kaffee/' => '10% Rabatt am Tag des Kaffees'
        ]
    ],
    [
        'claim' => 'weil Kaffee Dich auf die richtige Bahn bringt',
        'img'=> 'header-neue-roesterei',
        'buttons' => [
            '/produkt/gravity' => 'Gravity',
            '/produkt/space-rocket' => 'Space Rocket'
        ]
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
get_template_part('templates/introduction', null, [
    'text' => '<span>Am <a href="https://www.internationalcoffeeday.org/">internationalen Tag des Kaffees</a> feiern wir diejenigen, die hart arbeiten, um die drei Milliarden köstlichen Tassen Kaffee herzustellen, die wir jeden Tag auf der ganzen Welt genießen. Besucht am Samstag, den 01.10., unsere professionellen Baristas im Donaueinkaufszentrum in Regensburg. Zwischen _UHRZEIT_BEGINN_ und _UHRZEIT_ENDE_ zeigen Sie euch, was alles in dieser wertvollen Bohne steckt. Oder stöbert ein bisschen hier im Onlineshop und entdeckt neue Lieblingssorten. Dafür gibts am 01.10. 10% Rabatt auf alle Kaffees.</span>',
]);
get_template_part('templates/featured/slider');
?>
<div class="marketing-banner">
    <div class="container">
        <div class="marketing-banner-text">
            <h2>Wir sind umtriebig, vielfältig und kreativ - voller Mut und Energie, etwas Besonderes zu erschaffen. Einen Raum der Inspiration und Lebensfreude.
                Wir verbinden Menschen durch Genuss,
                wir leben Leidenschaft für hochwertige Produkte. Und das seit Generationen.</h2>
            <a class="learn-more" href="/tradition">erfahre mehr</a>
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
<?php
get_footer();
?>
