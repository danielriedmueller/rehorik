<div class="rehorik-header-outer">
    <header class="rehorik-header" data-scrollpos>
        <div id="top-bar">
            <div>Mit ❤️ aus Regensburg</div>
            <div>ShopVote ★★★★★</div>
            <div>Versandkostenfrei ab 69€</div>
            <div>Hilfe / Beratung</div>
            <?php
            wp_nav_menu(['theme_location' => 'top-bar']);
            get_template_part('templates/header/cart-total');
            if (is_active_sidebar('productsearch')) {
                dynamic_sidebar('productsearch');
            }
            ?>
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
