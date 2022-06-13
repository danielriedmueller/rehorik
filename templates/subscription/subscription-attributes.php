<?php
global $product;
$mahlgrade = getAttributeArray($product, MAHLGRAD_ATTRIBUTE_SLUG);
?>
<div class="rehorik-product-coffee-subscription">
    <p>Ein Kaffee pro Monat, ein Jahr lang!</p>
    <p>Abrechnung monatlich</p>
    <p>250g</p>
    <div class="mahlgrad-radiougroup-label">Mahlgrad</div>
    <ul class="mahlgrad-radiogroup" data-attribute_name="<?= ATTRIBUTE_SLUG_PREFIX.MAHLGRAD_ATTRIBUTE_SLUG?>" >
        <?php
        foreach ($mahlgrade as $slug => $name) {
            echo sprintf(
                '<li><input type="radio" name="%s" value="%s" id="%s" /><div class="variable-item" data-value="%s"><label for="%s">%s</label></div></li>',
                SUBSCRIPTION_COFFEE_MAHLGRAD,
                $slug,
                $slug,
                $slug,
                $slug,
                $name
            );
        }
        ?>
    </ul>
</div>
