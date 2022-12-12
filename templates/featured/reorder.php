<?php
$reh_mini_cart = Reh_Mini_Cart::instance();
$userId = $reh_mini_cart->getCurrentUserId();
$items = $reh_mini_cart->getReorderItems($userId);
?>
<h3>
    <?php if(!$userId) : ?>
        Was andere bestellt haben:
    <?php else: ?>
        Nochmal kaufen?
    <?php endif; ?>
</h3>
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
            <div><?= $item->getPrice() ?></div>
            <div>
                <?php foreach ($item->getViewAttributes() as $attribute) {
                    echo $attribute;
                } ?>
            </div>
            <button class="add-to-cart-recent-order-item"
                    data-product-id="<?= $item->getId() ?>"
                    data-variation-id="<?= $item->getVariationId() ?>"
                    data-attributes='<?= json_encode($item->getDataAttributes()) ?>'
            ></button>
        </li>
    <?php endforeach; ?>
</ul>