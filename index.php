<?php get_header(); ?>
<?php if (!is_checkout() && empty( is_wc_endpoint_url('order-received'))) : ?>
    <?php get_template_part('templates/page-title'); ?>
    <div class="container">
        <?php
        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();
                the_content();
            }
        }
        ?>
    </div>
<?php else: ?>
    <?php
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            the_content();
        }
    }
    ?>
<?php endif; ?>
<?php get_footer(); ?>
