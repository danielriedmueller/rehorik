<?php
get_header();
get_template_part('templates/header/slider', null, ['items' => [
    [
        'claim' => 'Vatertag - nicht Katertag!',
        'img'=> 'father2',
        'buttons' => [
            '/produkt-kategorie/onlineshop/spirits/brand/' => '15% Rabatt auf unsere guten Obstbrände'
        ]
    ],
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
<?php get_template_part('templates/hint') ?>
<div class="container hint-margin-top">
    <ul class="rehorik-products products">
        <li class="product-category product">
            <?php get_template_part('templates/orderbird-chooser'); ?>
        </li>
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
get_footer();
?>
