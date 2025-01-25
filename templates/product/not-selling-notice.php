<?php
global $product;
$saleInfo = $product->get_attribute(SALE_INFO_ATTRIBUTE_SLUG);
?>
<div class="not-selling-notice">
    <p>Um Dir eine optimale Beratung geben zu können, verkaufen wir dir die Maschinen nicht online. Gerne führen wir Dich in die Welt der Siebträgermaschinen persönlich ein.</p>
    <p><strong>Wo:</strong> Ausstellungsraum Rehorik Rösterei & Kaffeehaus | <a target="_blank" href="https://goo.gl/maps/7syuH8WaSkARVtDf6">Straubinger Straße 62a</a></p>
    <p class="mb-l">Wir bitten Dich, einen Termin auszuwählen oder schreib uns unter <a href="mailto:<?= BARISTASTORE_EMAIL ?>?subject=Maschinenberatung&body=Hallo%20Rehorik-Team,%0D%0A%0D%0AHIER%20STEHT%20DEINE%20NACHRICHT"><?= BARISTASTORE_EMAIL ?></a>.</p>
    <?php
    get_template_part('templates/product/make-machine-appointment');
    if ($saleInfo) {
        echo "<p class='price'>$saleInfo</p>";
    } else {
        woocommerce_template_single_price();
    }
    ?>
</div>
