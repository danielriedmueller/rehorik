<?php
// TODO: change medium size to 350 in /wp-admin/options-media.php
$products = wc_get_products([
    'featured' => true,
    'orderby' => 'modified',
    'order' => 'DESC',
]);

if (empty($products)) {
    return;
}
?>
<ul>
    <?php foreach ($products as $product): ?>
        <li><?php get_template_part('templates/featured/item', null, ['product' => $product, 'description' => false]) ?></li>
    <?php endforeach; ?>
</ul>
