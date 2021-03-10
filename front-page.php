<?php
get_header();
?>
<ul id="slider">
    <li>
        <div class="frontpage-slider-image-1"></div>
        <div class="slider-claim">
            <h2>Kaffeerösterei seit 1928</h2>
            <div>
                <a class="button" href="<?= get_term_link( get_term_by('slug', COFFEE_CATEGORY_SLUG, 'product_cat'), 'product_cat' ); ?>">Zum Kaffee</a>
                <a class="button" href="#">Unsere Kugelröster</a>
            </div>
        </div>
    </li>
    <li>
        <div class="frontpage-slider-image-2"></div>
        <div class="slider-claim">
            <h2>TRADITION, QUALITÄT, & LEIDENSCHAFT</h2>
            <div>
                <a class="button" href="<?= get_term_link( get_term_by('slug', COFFEE_FILTERKAFFEE_CATEGORY_SLUG, 'product_cat'), 'product_cat' ); ?>">Hier gibts Filterkaffee</a>
                <a class="button" href="<?= get_term_link( get_term_by('slug', COFFEE_ESPRESSO_CATEGORY_SLUG, 'product_cat'), 'product_cat' ); ?>">Und hier Espresso</a>
            </div>
        </div>
    </li>
    <li>
        <div class="frontpage-slider-image-3"></div>
        <div class="slider-claim">
            <h2>WIR KÖNNEN AUCH WEIN</h2>
            <div>
                <a class="button" href="<?= get_term_link( get_term_by('slug', WINE_SPIRITS_CO_CATEGORY_SLUG, 'product_cat'), 'product_cat' ); ?>">Zur Weinauswahl</a>
                <a class="button" href="<?= get_term_link( get_term_by('slug', WINE_SPIRITS_CO_CATEGORY_SLUG, 'product_cat'), 'product_cat' ); ?>">Und Spirituosen</a>
            </div>
        </div>
    </li>
</ul>
<div id="tns-controls-container">
    <button></button>
    <button></button>
</div>
<a id="rehorik-logo" href="<?php echo get_home_url(); ?>"></a>
<div class="page-title-outer">
    <div class='page-title'><h1>Shop</h1></div>
</div>
<div class="container">
    <ul class="rehorik-products products">
        <?php
        $product_categories = getShopFrontPageCategories( );
        foreach ( $product_categories as $category ) {
            wc_get_template(
                'content-product_cat.php',
                array(
                    'category' => $category,
                )
            );
        }
        ?>
    </ul>
</div>
<?php
get_template_part('templates/best-selling-products');
get_footer();
?>
