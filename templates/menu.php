<?php ?>
<header class="rehorik-header">
    <?= get_template_part('templates/hamburger'); ?>
    <?php wp_nav_menu(['theme_location' => 'main']); ?>
    <?= get_template_part('templates/cart-total'); ?>
    <?php if (is_active_sidebar('productsearch')) {
        dynamic_sidebar('productsearch');
    } ?>
</header>


