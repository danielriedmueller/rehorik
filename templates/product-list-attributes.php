<?php
global $product;

$price = wc_price($product->get_price());
if ($product->is_on_sale()) {
    if ($product->is_type('variable')) {
        $variations = $product->get_children();
        $salePrices = [];
        $regPrices = [];
        foreach ($variations as $value) {
            $singleVariation = new WC_Product_Variation($value);
            array_push($salePrices, $singleVariation->get_price());
            array_push($regPrices, $singleVariation->get_regular_price());
        }
        sort($salePrices);
        sort($regPrices);
        $salePrice = $salePrices[0];
        $regPrice = $regPrices[0];
        if (!isset($salePrices[0])) {
            $salePrice = $product->get_sale_price();
        }
        if (!isset($regPrices[0])) {
            $regPrice = $product->get_regular_price();
        }
    } else {
        $regPrice = $product->get_regular_price();
        $salePrice = $product->get_sale_price();
    }

    $price = wc_format_sale_price(
            wc_get_price_to_display($product, ['price' => $regPrice]),
            wc_get_price_to_display($product, ['price' => $salePrice]),
    ) . $product->get_price_suffix();
}

$strength = $product->get_attribute(STRENGTH_ATTRIBUTE_SLUG);
$flavoursvariety = $product->get_attribute(FLAVOUR_VARIETY_ATTRIBUTE_SLUG);
$ausbau = $product->get_attribute(AUSBAU_ATTRIBUTE_SLUG);
$giftContent = getAttributeArray($product, GIFT_CONTENT_ATTRIBUTE_SLUG);

$attributes = [];
$attributes[GRAPE_VARIETY_ATTRIBUTE_SLUG] = $product->get_attribute(GRAPE_VARIETY_ATTRIBUTE_SLUG);
$attributes[FLAVOUR_ATTRIBUTE_SLUG] = $product->get_attribute(FLAVOUR_ATTRIBUTE_SLUG);
$attributes[MANUFACTURER_ATTRIBUTE_SLUG] = $product->get_attribute(MANUFACTURER_ATTRIBUTE_SLUG);
$attributes[MILCHART_ATTRIBUTE_SLUG] = $product->get_attribute(MILCHART_ATTRIBUTE_SLUG);
$attributes[HERSTELLUNG_ATTRIBUTE_SLUG] = $product->get_attribute(HERSTELLUNG_ATTRIBUTE_SLUG);
$attributes = array_filter($attributes);
?>
<div class="rehorik-product-attributes">
    <div class='rehorik-product-min-price'><?= ($product->is_type('variable') ? "ab " : "") . $price . " *" ?></div>
    <table>
        <tbody>
            <?php if($strength): ?>
                <tr>
                    <td class="rehorik-product-strength-flavour-label-first"><?= wc_attribute_label(STRENGTH_ATTRIBUTE_SLUG) ?></td>
                    <td><?= getStrengthFlavourHtml($strength, 'strength') ?></td>
                </tr>
            <?php endif; ?>
            <?php if($flavoursvariety): ?>
                <tr>
                    <td class="rehorik-product-strength-flavour-label-second"><?= wc_attribute_label(FLAVOUR_VARIETY_ATTRIBUTE_SLUG) ?></td>
                    <td><?= getStrengthFlavourHtml($flavoursvariety, 'flavour'); ?></td>
                </tr>
            <?php endif; ?>
            <?php if(!empty($attributes) || !empty($giftContent)): ?>
                <tr class="seperator">
                    <td colspan="2"><hr /></td>
                </tr>
            <?php endif; ?>
            <?php foreach($attributes as $key =>$value): ?>
                <tr>
                    <td><?= wc_attribute_label($key) ?></td>
                    <td class="rehorik-product-attribute-list"><?= $value ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if(!empty($giftContent)): ?>
                <tr>
                    <td class="rehorik-product-attribute-list">
                        <ul>
                            <?php foreach($giftContent as $value): ?>
                                <li><?= $value ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php if($ausbau): ?>
        <div class="rehorik-product-ausbau"><?= $ausbau ?></div>
    <?php endif; ?>
</div>