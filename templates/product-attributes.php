<?php
global $product;

$price = wc_price($product->get_price());

$strengthSlug = 'pa_kaffee-staerke';
$flavoursvarietySlug = 'pa_kaffee-aromenvielfalt';
$flavoursSlug = 'pa_kaffee-aromen';

$strength = $product->get_attribute($strengthSlug);
$flavoursvariety = $product->get_attribute($flavoursvarietySlug);
$flavours = $product->get_attribute($flavoursSlug);

?>
<div class="rehorik-product-attributes">
    <div class='rehorik-product-min-price'>ab <?php echo $price ?></div>
    <table>
        <tbody>
            <?php if($strength): ?>
                <tr>
                    <td class="rehorik-product-strength-flavour-label-first"><?php echo wc_attribute_label($strengthSlug) ?></td>
                    <td><?php do_action('render_product_attribute_strength_flavour', $strength, 'strength'); ?></td>
                </tr>
            <?php endif; ?>
            <?php if($flavoursvariety): ?>
                <tr>
                    <td class="rehorik-product-strength-flavour-label-second"><?php echo wc_attribute_label($flavoursvarietySlug) ?></td>
                    <td><?php do_action('render_product_attribute_strength_flavour', $flavoursvariety, 'flavour'); ?></td>
                </tr>
            <?php endif; ?>
            <?php if($flavours): ?>
                <tr class="seperator">
                    <td colspan="2"><hr /></td>
                </tr>
                <tr>
                    <td><?php echo wc_attribute_label($flavoursSlug) ?></td>
                    <td class="rehorik-product-flavours-list"><?php echo $flavours ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>