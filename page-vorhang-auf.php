<?php
get_header();

$postsPerPage = 3;

$news = get_posts([
    'post_type' => 'post',
    'category_name' => NEWS_CATEGORY_SLUG,
    'posts_per_page' => $postsPerPage,
]);

$talkCoffee = get_posts([
    'post_type' => 'post',
    'category_name' => LETS_TALK_COFFEE_CATEGORY_SLUG,
    'posts_per_page' => $postsPerPage,
]);

$knowledge = get_posts([
    'post_type' => 'post',
    'category_name' => COFFEE_KNOWLEDGE_CATEGORY_SLUG,
    'posts_per_page' => $postsPerPage,
]);
?>
<div id="vorhang-auf">
    <div class="news">
        <?php get_template_part('templates/vorhang-auf-posts', null, ['title' => 'News', 'posts' => $news]) ?>
    </div>
    <div class="lets-talk-coffee">
        <?php get_template_part('templates/vorhang-auf-posts', null, ['title' => 'Lets talk coffee', 'posts' => $talkCoffee]) ?>
    </div>
    <div class="coffee-knowledge">
        <?php get_template_part('templates/vorhang-auf-posts', null, ['title' => 'Kaffeewissen', 'posts' => $knowledge]) ?>
    </div>
</div>
<?php get_footer(); ?>
