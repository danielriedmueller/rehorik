<?php
get_header();

$news = get_posts([
    'post_type' => 'post',
    'category_name' => NEWS_CATEGORY_SLUG
]);

?>
<div id="vorhang-auf" class="category">
    <div class="news">
        <?php get_template_part('templates/vorhang-auf-posts', null, ['title' => 'News', 'posts' => $news]) ?>
    </div>
</div>
<?php get_footer(); ?>
