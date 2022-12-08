<?php


if (empty($products)) {
    return;
}
?>
<ul>
    <?php foreach ($products as $product): ?>
        <li><?php get_template_part('templates/featured/item', null, ['product' => $product, 'description' => false]) ?></li>
    <?php endforeach; ?>
</ul>
