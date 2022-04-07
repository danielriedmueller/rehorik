<?php $product = $args['product']; ?>
<div class="sigil-container">
    <?php if (hasBioSigil($product)): ?>
        <div class="<?= getBioSigilClass($product) ?>"></div>
    <?php endif; ?>
    <?php if (hasVeganSigil($product)): ?>
        <div class="<?= getVeganSigilClass($product) ?>"></div>
    <?php endif; ?>
</div>