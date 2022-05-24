<?php $product = $args['product']; ?>
<div class="sigil-container">
    <?php if (!empty($class = getIsEventOnlineClass($product))): ?>
        <div class="<?= $class ?>"></div>
    <?php endif; ?>
    <?php if (isProductOfTheMonth($product)): ?>
        <div title="Produkt des Monats" class="<?= getProductOfTheMonthClass($product) ?>"></div>
    <?php endif; ?>
    <?php if (hasBioSigil($product)): ?>
        <div class="<?= getBioSigilClass($product) ?>"></div>
    <?php endif; ?>
    <?php if (hasVeganSigil($product)): ?>
        <div title="Vegan" class="<?=getVeganSigilClass($product)?>"></div>
    <?php endif; ?>
    <?php if (hasBiodynamicSigil($product)): ?>
        <div title="Biodynamisch" class="<?= getBiodynamicSigilClass($product) ?>"></div>
    <?php endif; ?>
    <?php if (hasRegionalSigil($product)): ?>
        <div title="Regional" class="<?= getRegionalSigilClass($product) ?>"></div>
    <?php endif; ?>
</div>