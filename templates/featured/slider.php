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
<div class="slider-outer" id="rehorik-featured-products">
    <div class="container">
        <?php if (sizeof($products) > 1) : ?>
            <ul id="slider-body" class="slider">
                <li><?php get_template_part('templates/featured/geschenke') ?></li>
                <?php foreach ($products as $product): ?>
                    <li><?php get_template_part('templates/featured/item', null, ['product' => $product]) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php if (sizeof($products) === 1) : ?>
            <?php get_template_part('templates/featured/item', null, ['product' => $productList[0]]) ?>
        <?php endif; ?>
    </div>
    <div id="slider-body-controls" class="slider-controls">
        <button></button>
        <button></button>
    </div>
</div>
