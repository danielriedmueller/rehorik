<?php ?>

<ul id="slider">
    <?php foreach($args['images'] as $image): ?>
        <li>
            <img src="<?= get_stylesheet_directory_uri() . $image ?>" />
            <div class="slider-claim">
                <h2>Kaffeerösterei seit 1928</h2>
                <div>
                    <a class="button" href="<?= get_term_link( get_term_by('slug', COFFEE_CATEGORY_SLUG, 'product_cat'), 'product_cat' ); ?>">Zum Kaffee</a>
                    <a class="button" href="#">Unsere Kugelröster</a>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
<div id="tns-controls-container">
    <button></button>
    <button></button>
</div>
