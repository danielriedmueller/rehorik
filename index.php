<?php get_header(); ?>
<div class="page-title-outer">
    <div class='page-title'><h1><?= the_title() ?></h1></div>
</div>
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
<?php get_footer(); ?>
