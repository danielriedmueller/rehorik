<div class="rehorik-header-outer">
    <header class="rehorik-header" data-scrollpos>
        <?php get_template_part('templates/header/hamburger'); ?>
        <div id="top-bar">
            <div class="top-bar-left">
                <?php
                if (is_active_sidebar('productsearch')) {
                    dynamic_sidebar('productsearch');
                }
                ?>
            </div>
            <div class="top-bar-center">
                <div class="help-icon">Hilfe / Kontakt: <?= CONTACT_PHONE ?></div>
                <div class="bean-claim">Mit <span class="bean-icon"></span> aus Regensburg</div>
                <div class="shipping-icon">Versandkostenfrei ab 69€</div>
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
            wp_nav_menu(['theme_location' => 'main']);
            get_template_part('templates/social-media-icons', null, ['withLogo' => true]);
            ?>
        </div>
    </header>
    <?php get_template_part('templates/social-media-icons'); ?>
</div>
