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
        <?php get_template_part('templates/vorhang-auf-posts', null, ['title' => 'News', 'posts' => $news, 'category' => NEWS_CATEGORY_SLUG]) ?>
    </div>
    <div class="lets-talk-about">
        <?php get_template_part('templates/vorhang-auf-posts', null, ['title' => 'Let‘s Talk About', 'posts' => $talkCoffee, 'category' => LETS_TALK_COFFEE_CATEGORY_SLUG]) ?>
    </div>
    <div class="coffee-knowledge">
        <?php get_template_part('templates/vorhang-auf-posts', null, ['title' => 'Kaffeewissen', 'posts' => $knowledge, 'category' => COFFEE_KNOWLEDGE_CATEGORY_SLUG]) ?>
    </div>
</div>
<?php get_footer(); ?>
