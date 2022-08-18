<?php
// TODO: change medium size to 350 in /wp-admin/options-media.php
$productList = wc_get_featured_product_ids();

if (empty($productList)) {
    return;
}
?>
<div class="slider-outer" id="rehorik-featured-products">
    <div class="container">
        <?php if (sizeof($productList) > 1) : ?>
            <ul id="slider-body" class="slider">
                <?php foreach ($productList as $productId): ?>
                    <?php if ($product = wc_get_product($productId)): ?>
                        <li><?php get_template_part('templates/featured/item', null, ['product' => $product]) ?></li>
                    <?php endif;?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php if (sizeof($productList) === 1) : ?>
            <?php if ($product = wc_get_product($productList[0])): ?>
                <?php get_template_part('templates/featured/item', null, ['product' => $product]) ?>
            <?php endif;?>
        <?php endif; ?>
    </div>
    <div id="slider-body-controls" class="slider-controls">
        <button></button>
        <button></button>
    </div>
</div>
