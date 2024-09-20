<?php
get_header();

$knowledge = get_posts([
    'post_type' => 'post',
    'category_name' => COFFEE_KNOWLEDGE_CATEGORY_SLUG
]);
?>
<div id="vorhang-auf" class="category">
    <div class="coffee-knowledge">
        <?php get_template_part('templates/vorhang-auf-posts', null, ['title' => 'Kaffeewissen', 'posts' => $knowledge]) ?>
    </div>
</div>
<?php get_footer(); ?>
