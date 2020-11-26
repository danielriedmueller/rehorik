<?php
global $product;

$price = wc_price($product->get_price());

$strength = $product->get_attribute(STRENGTH_ATTRIBUTE_SLUG);
$flavoursvariety = $product->get_attribute(FLAVOUR_VARIETY_ATTRIBUTE_SLUG);
$flavours = $product->get_attribute(FLAVOUR_ATTRIBUTE_SLUG);
$varieties = $product->get_attribute(VARIETIES_ATTRIBUTE_SLUG);
$grapeVariety = $product->get_attribute(GRAPE_VARIETY_ATTRIBUTE_SLUG);
$ausbau = $product->get_attribute(AUSBAU_ATTRIBUTE_SLUG);
$herstellung = $product->get_attribute(HERSTELLUNG_ATTRIBUTE_SLUG);
$manufacturer = $product->get_attribute(MANUFACTURER_ATTRIBUTE_SLUG);
$milchart = $product->get_attribute(MILCHART_ATTRIBUTE_SLUG);

?>
<div class="rehorik-product-attributes">
    <div class='rehorik-product-min-price'><?= ($product->is_type('variable') ? "ab " : "") . $price ?></div>
    <table>
        <tbody>
            <?php if($strength): ?>
                <tr>
                    <td class="rehorik-product-strength-flavour-label-first"><?= wc_attribute_label(STRENGTH_ATTRIBUTE_SLUG) ?></td>
                    <td><?php do_action('render_product_attribute_strength_flavour', $strength, 'strength'); ?></td>
                </tr>
            <?php endif; ?>
            <?php if($flavoursvariety): ?>
                <tr>
                    <td class="rehorik-product-strength-flavour-label-second"><?= wc_attribute_label(FLAVOUR_VARIETY_ATTRIBUTE_SLUG) ?></td>
                    <td><?php do_action('render_product_attribute_strength_flavour', $flavoursvariety, 'flavour'); ?></td>
                </tr>
            <?php endif; ?>
            <tr class="seperator">
                <td colspan="2"><hr /></td>
            </tr>
            <?php if($varieties): ?>
                <tr>
                    <td><?= wc_attribute_label(VARIETIES_ATTRIBUTE_SLUG) ?></td>
                    <td class="rehorik-product-varieties-list">
                        <?= sprintf(
                            '%s%s',
                            $varieties,
                            empty($grapeVariety) ? "" : ", " . $grapeVariety
                        ); ?>
                    </td>
                </tr>
            <?php endif; ?>
            <?php if($flavours): ?>
                <tr>
                    <td><?= wc_attribute_label(FLAVOUR_ATTRIBUTE_SLUG) ?></td>
                    <td class="rehorik-product-flavours-list"><?= $flavours ?></td>
                </tr>
            <?php endif; ?>
            <?php if($manufacturer): ?>
                <tr>
                    <td><?= wc_attribute_label(MANUFACTURER_ATTRIBUTE_SLUG) ?></td>
                    <td class="rehorik-product-flavours-list"><?= $manufacturer ?></td>
                </tr>
            <?php endif; ?>
            <?php if($milchart): ?>
                <tr>
                    <td><?= wc_attribute_label(MILCHART_ATTRIBUTE_SLUG) ?></td>
                    <td class="rehorik-product-flavours-list"><?= $milchart ?></td>
                </tr>
            <?php endif; ?>
            <?php if($herstellung): ?>
                <tr>
                    <td><?= wc_attribute_label(HERSTELLUNG_ATTRIBUTE_SLUG) ?></td>
                    <td class="rehorik-product-flavours-list"><?= $herstellung ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php if($ausbau): ?>
        <div class="rehorik-product-ausbau"><?= $ausbau ?></div>
    <?php endif; ?>
</div>