<?php ?>
<div class="rehorik-header-outer">
    <header class="rehorik-header" data-scrollpos>
        <?= get_template_part('templates/hamburger'); ?>
        <?php wp_nav_menu(['theme_location' => 'main']); ?>
        <?= get_template_part('templates/cart-total'); ?>
        <?php if (is_active_sidebar('productsearch')) {
            dynamic_sidebar('productsearch');
        } ?>
    </header>
</div>


