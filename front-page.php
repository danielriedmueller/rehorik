<?php
get_template_part('templates/header/head', null, ['slider' => [
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
