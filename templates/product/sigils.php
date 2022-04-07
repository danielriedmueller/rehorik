<?php $product = $args['product']; ?>
<div class="sigil-container">
    <?php if (hasBioSigil($product)): ?>
        <div title="Bio" class="<?=getBioSigilClass($product)?>"><?=getBioSigilControlcode($product)?></div>
        <div title="Bio" class="<?=getBioSigilClass($product)?>-de"></div>
    <?php endif; ?>
    <?php if (hasVeganSigil($product)): ?>
        <div title="Vegan" class="<?=getVeganSigilClass($product)?>"></div>
    <?php endif; ?>
    <?php if (hasBiodynamicSigil($product)): ?>
        <div title="Biodynamisch" class="<?= getBiodynamicSigilClass($product) ?>"></div>
    <?php endif; ?>
</div>