<?php
if (!PLUGINS_ACTIVE) {
    echo 'Plugins not active';
    return;
}

get_header();
get_template_part('templates/rehorik-locations');
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
