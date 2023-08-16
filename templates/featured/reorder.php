<?php
$userId = Reh_Mini_Cart::getCurrentUserId();
$buyAgain = false;
if ($userId) {
    $buyAgain = true;
}
$items = Reh_Mini_Cart::getReorderItems($userId);
if ($userId && empty($items)) {
    $items = Reh_Mini_Cart::getReorderItems(null);
    $buyAgain = false;
}
?>
<h2>
    <?php if(!$buyAgain) : ?>
        Andere kauften auch:
    <?php else: ?>
        Nochmal kaufen?
    <?php endif; ?>
</h2>
<ul class="rehorik-mini-cart-item-list">
    <?php foreach ($items as $item) : ?>
        <li class="rehorik-mini-cart-item">
            <?php if ($item->hasPermalink()) : ?>
                <a href="<?php echo esc_url($item->getPermalink()); ?>">
                    <?php echo $item->getThumbnail() . $item->getName(); ?>
                </a>
            <?php else : ?>
                <?php echo $item->getThumbnail() . $item->getName(); ?>
            <?php endif; ?>
            <div class="mini-cart-item-attributes"><?php foreach ($item->getViewAttributes() as $attribute) {echo $attribute;} ?></div>
            <div>
                <button class="add-to-cart-recent-order-item"
                        data-product-id="<?= $item->getId() ?>"
                        data-variation-id="<?= $item->getVariationId() ?>"
                        data-attributes='<?= json_encode($item->getDataAttributes()) ?>'
                ></button>
                <div class="mini-cart-item-price"><?= $item->getPrice() ?></div>
            </div>
        </li>
    <?php endforeach; ?>
</ul>