<?php get_header(); ?>
<?php if (is_wc_endpoint_url('order-received')) : ?>
    <?php
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            the_content();
        }
    }
    ?>
<?php else: ?>
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
<?php endif; ?>
<?php get_footer(); ?>
