<?php
global $product;

$price = wc_price($product->get_price());

$strength = $product->get_attribute(STRENGTH_ATTRIBUTE_SLUG);
$flavoursvariety = $product->get_attribute(FLAVOUR_VARIETY_ATTRIBUTE_SLUG);


$grapeVariety = $product->get_attribute(GRAPE_VARIETY_ATTRIBUTE_SLUG);
$ausbau = $product->get_attribute(AUSBAU_ATTRIBUTE_SLUG);
$giftContent = getAttributeArray($product, GIFT_CONTENT_ATTRIBUTE_SLUG);

$attributes = [];
$attributes[VARIETIES_ATTRIBUTE_SLUG] = sprintf(
    '%s%s',
    $product->get_attribute(VARIETIES_ATTRIBUTE_SLUG),
    empty($grapeVariety) ? "" : ", " . $grapeVariety
);
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