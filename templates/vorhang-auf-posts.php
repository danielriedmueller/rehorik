<?php
$title = $args['title'];
$posts = $args['posts'];
?>
<h2><?= $title ?></h2>
<?php foreach ($posts as $post): ?>
    <?php setup_postdata($post); ?>
    <div class="vorhang-auf-post">
        <h3><?php the_title(); ?></h3>
        <p><?php the_excerpt(); ?></p>
        <a href="<?php the_permalink(); ?>">Mehr erfahren</a>
    </div>
<?php endforeach; ?>

