<?php get_header(null, [Reh_Page_Header_Image::META_HEADER_SHOW_TITLE => true]); ?>
    <div class="container post-container">
        <?php
        the_post();
        the_content();
        ?>
    </div>
<?php get_footer(); ?>