<?php
if (!isset($args['product'])) {
    return;
}

$product = $args['product'];

$mergeDescriptions = function ($description, $shortDescription) {
    $description = ucfirst(trim($description));

    if (empty($shortDescription)) {
        return $description;
    }

    if (!str_ends_with($description, '.') && !str_ends_with($description, '?') && !str_ends_with($description, '!')) {
        $description .= '.';
    }

    return $description . '<br>' . $shortDescription;
};
?>
<div>
    <div class="image">
        <a href="<?= $product->get_permalink() ?>">
            <?php get_template_part('templates/loop/sigils', null, ['product' => $product]) ?>
            <?= $product->get_image('medium') ?>
        </a>
    </div>
    <div class="text">
        <span class="category"><?= getSubCategories($product, true) ?></span>
        <h3><?= $product->get_title() ?></h3>
        <span class="description"><?= $mergeDescriptions($product->get_description(), $product->get_short_description()) ?></span>
        <span class="learn-more"><a href="<?= $product->get_permalink() ?>">erfahre mehr</a></span>
    </div>
</div>