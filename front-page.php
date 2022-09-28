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
    'text' => '<span>Am <a href="https://www.internationalcoffeeday.org/">internationalen Tag des Kaffees</a> feiern wir diejenigen, die hart arbeiten, um die drei Milliarden köstlichen Tassen Kaffee herzustellen, die wir jeden Tag auf der ganzen Welt genießen. Wir wollen zeigen, was in und hinter der Bohne steckt und warum sie so schmeckt, wie sie schmeckt. Begebt Euch mit uns auf einer kleinen Weltreise und verkostet mit unserm Kaffeeakademie-Team am 01.10.22 in unserer Filiale im Donaueinkaufszenturm die Vielfalt des Kaffees. Nicht in Regensburg? Dann stöbert doch einfach ein bisschen hier im Onlineshop und entdeckt neue Lieblingssorten. Dafür gibt’s am 01.10.22 10% Rabatt auf alle Kaffees.</span>',
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
