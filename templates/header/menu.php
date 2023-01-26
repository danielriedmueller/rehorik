<div class="rehorik-header-outer">
    <header class="rehorik-header" data-scrollpos>
        <div id="top-bar">
            <div class="top-bar-left">
                <?php
                if (is_active_sidebar('productsearch')) {
                    dynamic_sidebar('productsearch');
                }
                ?>
            </div>
            <div class="top-bar-center">
                <div>Hilfe / Beratung: <?= CONTACT_PHONE ?></div>
                <div>Mit <span class="bean-icon"></span> aus Regensburg</div>
                <div>Versandkostenfrei ab 69€</div>
            </div>
            <div class="top-bar-right">
                <?php
                get_template_part('templates/header/cart-total');
                wp_nav_menu(['theme_location' => 'top-bar']);
                ?>
            </div>
        </div>
        <div id="rehorik-menu">
            <?php
            get_template_part('templates/header/hamburger');
            wp_nav_menu(['theme_location' => 'main']);
            get_template_part('templates/social-media-icons', null, ['withLogo' => true]);
            ?>
        </div>
    </header>
    <?php get_template_part('templates/social-media-icons'); ?>
</div>
