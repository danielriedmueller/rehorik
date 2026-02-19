<?php
get_header();

$talkCoffee = get_posts([
    'post_type' => 'post',
    'category_name' => LETS_TALK_COFFEE_CATEGORY_SLUG
]);
?>
<div id="vorhang-auf" class="category">
    <div class="lets-talk-about">
        <?php get_template_part('templates/vorhang-auf-posts', null, ['title' => 'Let‘s Talk About', 'posts' => $talkCoffee]) ?>
    </div>
</div>
<?php get_footer(); ?>
