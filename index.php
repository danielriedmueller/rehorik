<?php
if (!PLUGINS_ACTIVE) {
    echo 'Plugins not active';
    return;
}

get_header();
?>
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
