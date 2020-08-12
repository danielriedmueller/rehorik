<?php get_header(); ?>
    <div class="banner-outer">
        <span>
            Kostenloser Versand ab Mindestbestellwert von
            <?php do_action('render_free_shipping_amount'); ?>
        </span>
    </div>
    <div id="main-content">
        <div class="container">
            <div id="content-area" class="cart">
                <?php
                while (have_posts()) : the_post(); ?>
                    <?php the_content(); ?>
                <?php
                endwhile;
                wp_reset_query();
                ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>