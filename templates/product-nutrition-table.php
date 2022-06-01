<?php
global $product;

$fields = [];
foreach (define_nutrition_data_fields() as $id => $field) {
    $value = $product->get_meta($id);
    if ($value) {
        $fields[] = [
            'label' => $field['label'],
            'unit' => $field['unit'],
            'value' => $value
        ];
    }
}
?>
<?php if (!empty($fields)) : ?>
<div class="rehorik-nutrition-table">
    <h4>Nährwerte</h4>
    <table>
        <tbody>
            <?php foreach ($fields as $field) : ?>
                <tr>
                    <td><?= $field['label'] ?></td>
                    <td><?= $field['value'] . " " .  $field['unit'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
