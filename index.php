<?php
$title = get_the_title();
if (tribe_is_event()
    || tribe_is_event_category()
    || tribe_is_in_main_loop()
    || tribe_is_view()
    || 'tribe_events' == get_post_type()
    || is_singular('tribe_events')) {
    $title = "Veranstaltungen";
}

get_header();
?>
<div class="page-title-outer">
    <div class='page-title'><h1><?= $title ?></h1></div>
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
