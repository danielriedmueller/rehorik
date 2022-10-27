<?php
if (!isset($args['product'])) {
    return;
}

$product = $args['product'];

$mergeDescriptions = function ($description, $shortDescription, $claim) {
    $cleanUpText = function($text) {
        $text = str_replace( '</li>', ', ', $text);
        $text = ucfirst(trim(strip_tags($text)));
        $text = rtrim($text, ',');

        if (!str_ends_with($text, '.') && !str_ends_with($text, '?') && !str_ends_with($text, '!')) {
            $text .= '.';
        }

        return $text;
    };

    $result = $shortDescription ? $cleanUpText($description) . ' ' . $cleanUpText($shortDescription) : $cleanUpText($description);

    $charsToNewLine = 52;
    $claimLength = strlen($claim);
    $claimLines = $claimLength > 0 ? (int) ceil($claimLength / $charsToNewLine) : 0;
    $width = 350 - $charsToNewLine * $claimLines;

    return mb_strimwidth($result, 0, $width, "...");
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
        <h3><a href="<?= $product->get_permalink() ?>"><?= $product->get_title() ?></a></h3>
        <?php if($claim = $product->get_meta('reh_product_title_claim')) {
            echo "<span class='claim'>${claim}</span>";
        } ?>
        <span class="description"><?= $mergeDescriptions($product->get_description(), $product->get_short_description(), $product->get_meta('reh_product_title_claim')) ?></span>
        <span class="learn-more"><a href="<?= $product->get_permalink() ?>">erfahre mehr</a></span>
    </div>
</div>