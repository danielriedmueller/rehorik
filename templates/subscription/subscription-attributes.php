<?php
global $product;
$mahlgrade = explode(',', $product->get_attribute('pa_mahlgrad'));
?>
<div class="rehorik-product-coffee-subscription">
    <p>Ein Kaffee pro Monat, ein Jahr lang!</p>
    <p>Abrechnung monatlich</p>
    <p>250g</p>
    <label>
        Wähle den Mahlgrad
        <select name="<?= SUBSCRIPTION_COFFEE_MAHLGRAD ?>">
            <?php
            foreach ($mahlgrade as $key => $mahlgrad) {
                echo sprintf('<option value="%s">%s</option>', $mahlgrad, $mahlgrad);
            }
            ?>
        </select>
    </label>
</div>
