<?php
$title = $args['title'];
$posts = $args['posts'];
$cat = $args['category'];
?>
<h2><?= $title ?></h2>
<?php foreach ($posts as $post): ?>
    <?php setup_postdata($post); ?>
    <div class="vorhang-auf-post">
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <p><?php the_excerpt(); ?></p>
    </div>
<?php endforeach; ?>
<?php if ($cat): ?>
    <a class="more-posts" href="<?= get_term_link($cat, 'category'); ?>">Mehr dazu</a>
<?php endif ?>

