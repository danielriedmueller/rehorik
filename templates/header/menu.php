<div class="rehorik-header-outer">
    <header class="rehorik-header" data-scrollpos>
        <?php
        get_template_part('templates/header/hamburger');
        wp_nav_menu(['theme_location' => 'main']);
        get_template_part('templates/social-media-icons', null, ['withLogo' => true]);
        get_template_part('templates/header/cart-total');
        if (is_active_sidebar('productsearch')) {
            dynamic_sidebar('productsearch');
        }
        ?>
    </header>
    <?php get_template_part('templates/social-media-icons'); ?>
</div>
