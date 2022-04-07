<?php $product = $args['product']; ?>
<div class="sigil-container">
    <?php if (hasBioSigil($product)): ?>
        <div class="<?=getBioSigilClass($product)?>"><?=getBioSigilControlcode($product)?></div>
        <div class="<?=getBioSigilClass($product)?>-de"></div>
    <?php endif; ?>
    <?php if (hasVeganSigil($product)): ?>
        <div class="<?=getVeganSigilClass($product)?>"></div>
    <?php endif; ?>
    <?php if (hasBiodynamicSigil($product)): ?>
        <div class="<?= getBiodynamicSigilClass($product) ?>"></div>
    <?php endif; ?>
</div>