<?php get_header(); ?>

<div id="main-content">
    <div class="container">
        <div id="content-area" class="clearfix">
            <div id="left-area">
                <?php
                    if ( have_posts() ) {
                        while ( have_posts() ) {
                            the_post();
                            get_template_part( 'templates/content/content');
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
