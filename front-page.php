<?php
get_header();
get_template_part('templates/header/slider', null, ['items' => [
    [
        'claim' => 'Sommerfest & Sommerweinprobe',
        'img'=> 'weinfest',
        'text' => 'Keine Lust mehr auf anonyme Flaschen im Weinregal? Dann kommt zu unserem Sommerfest & lernt die Winzer:innen Eurer Lieblingsweine kennen. Wann? 25.6 / 14 - 22 Uhr. Wo? Am Brixener Hof 6.',
        'buttons' => [
            '/produkt-kategorie/veranstaltungen/wein-events/weinprobe/' => 'Sommerweinprobe 23. - 24.6.',
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
?>
<a id="rehorik-logo" href="<?php echo get_home_url(); ?>"></a>
<div class="page-title-outer">
    <div class='page-title'><h1>Kaffe, Wein und Spirits aus Regensburg</h1></div>
</div>
<div class="rehorik-page-introduction-outer">
    <div class="container">
        <div class="rehorik-page-introduction">
            Kaffee aus eigener Traditions-Rösterei seit vier Generationen vom Hause Rehorik. Wir führen auch eine hervorragend sortierte Wein- und Spirituosenauswahl.
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nulla
        </div>
    </div>
</div>
<?php get_template_part('templates/hint') ?>
<div class="container hint-margin-top">
    <ul class="rehorik-products products">
        <li class="product-category product">
            <?php get_template_part('templates/coffee-chooser'); ?>
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
            <?php get_template_part('templates/orderbird-chooser'); ?>
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
