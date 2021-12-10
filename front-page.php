<?php
get_header( );
?>
<ul id="slider">
    <li>
        <div class="frontpage-slider-image-5"></div>
        <div class="slider-claim">
            <h1>Es weihnachtet!</h1>
            <div>
                <a class="button" href="<?= get_term_link( get_term_by('slug', GIFTS_CATEGORY_SLUG, 'product_cat'), 'product_cat' ); ?>">Geschenke für Geniesser:innen</a>
            </div>
        </div>
    </li>
    <li>
        <div class="frontpage-slider-image-4"></div>
        <div class="slider-claim">
            <h1>Intergalaktisch gut!</h1>
            <div>
                <a class="button" href="<?= get_page_link(NEUE_ROESTEREI_PAGE_ID) ?>">Neue Rösterei: Wir starten durch!</a>
            </div>
        </div>
    </li>
    <li>
        <div class="frontpage-slider-image-1"></div>
        <div class="slider-claim">
            <h1>Kaffeerösterei seit 1928</h1>
            <div>
                <a class="button" href="<?= get_term_link( get_term_by('slug', COFFEE_CATEGORY_SLUG, 'product_cat'), 'product_cat' ); ?>">Zum Kaffee</a>
                <a class="button" href="<?= get_page_link(ROESTEREI_PAGE_ID) ?>">Unser Kugelröster</a>
            </div>
        </div>
    </li>
    <li>
        <div class="frontpage-slider-image-2"></div>
        <div class="slider-claim">
            <h1>TRADITION, QUALITÄT & LEIDENSCHAFT</h1>
            <div>
                <a class="button" href="<?= get_term_link( get_term_by('slug', COFFEE_FILTERKAFFEE_CATEGORY_SLUG, 'product_cat'), 'product_cat' ); ?>">Hier gibts Filterkaffee</a>
                <a class="button" href="<?= get_term_link( get_term_by('slug', COFFEE_ESPRESSO_CATEGORY_SLUG, 'product_cat'), 'product_cat' ); ?>">Und hier Espresso</a>
            </div>
        </div>
    </li>
    <li>
        <div class="frontpage-slider-image-3"></div>
        <div class="slider-claim">
            <h1>WIR KÖNNEN AUCH WEIN</h1>
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
                Aufgrund von Lieferproblemen beim Rohkaffe kommt es bei einigen Kaffeesorten zu einer Versandverzögerung.
                Wir bitten um Verständnis.
            </div>
        </div>
    </div>
</div>
<div class="container hint-margin-top">
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
