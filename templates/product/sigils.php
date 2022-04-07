<?php $product = $args['product']; ?>
<div class="sigil-container">
    <?php if (hasBiosigil($product)): ?>
        <div class="<?=getBiosigilClass($product)?>"><?=getBiosigilControlcode($product)?></div>
        <div class="<?=getBiosigilClass($product)?>-de"></div>
    <?php endif; ?>
    <?php if (hasVegansigil($product)): ?>
        <div class="<?=getVegansigilClass($product)?>"></div>
    <?php endif; ?>
</div>