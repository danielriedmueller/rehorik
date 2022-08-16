<?php
if (!isset($args['product'])) {
    return;
}

$product = $args['product'];

$mergeDescriptions = function ($description, $shortDescription) {
    $cleanUpText = function($text) {
        $text = str_replace( '</li>', ', ', $text);

        $text = ucfirst(trim(strip_tags($text)));

        if (!str_ends_with($text, '.') && !str_ends_with($text, '?') && !str_ends_with($text, '!')) {
            $text .= '.';
        }

        return $text;
    };

    $result = $shortDescription ? $cleanUpText($description) . ' ' . $cleanUpText($shortDescription) : $cleanUpText($description);

    return mb_strimwidth($result, 0, 330, "...");
};
?>
<div class="featured-product">
    <div class="image">
        <a href="<?= $product->get_permalink() ?>">
            <?php get_template_part('templates/loop/sigils', null, ['product' => $product]) ?>
            <?= $product->get_image('medium') ?>
        </a>
    </div>
    <div class="text">
        <span class="category"><?= getSubCategories($product, true) ?></span>
        <h3><?= $product->get_title() ?></h3>
        <?php if($claim = $product->get_meta('reh_product_title_claim')) {
            echo "<span class='claim'>${claim}</span>";
        } ?>
        <span class="description"><?= $mergeDescriptions($product->get_description(), $product->get_short_description()) ?></span>
        <span class="learn-more"><a href="<?= $product->get_permalink() ?>">erfahre mehr</a></span>
    </div>
</div>