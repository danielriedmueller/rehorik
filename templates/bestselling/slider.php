<?php
// TODO: change medium size to 350 in /wp-admin/options-media.php
$productList = [29128, 28333, 18078, 21769, 18738, 674];

?>
<div class="slider-outer" id="rehorik-best-selling-products">
    <ul id="slider-body" class="slider">
        <?php foreach ($productList as $productId): ?>
            <?php if ($product = wc_get_product($productId)): ?>
                <li><?php get_template_part('templates/bestselling/item', null, ['product' => $product]) ?></li>
            <?php endif;?>
        <?php endforeach; ?>
    </ul>
    <div id="slider-body-controls" class="slider-controls">
        <button></button>
        <button></button>
    </div>
</div>
