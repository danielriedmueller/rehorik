<div class="rehorik-header-outer">
    <header class="rehorik-header" data-scrollpos>
        <?php get_template_part('templates/header/hamburger'); ?>
        <div id="rehorik-menu">
            <?php
            get_template_part('templates/header/social-media-icons', null, ['withLogo' => true]);
            wp_nav_menu([
                    'theme_location' => 'main',
                    'container' => 'nav',
            ]);
            get_template_part('templates/header/top-bar');
            ?>
        </div>
    </header>
    <?php get_template_part('templates/header/social-media-icons'); ?>
</div>
