<?php
$description = null;
if (is_product_category() || is_shop()) {
    $cat = get_queried_object();
    if (!empty($cat)) {
        $description = $cat->description;
    }
}
?>
<?php if (!empty($description)) : ?>
    <div class="rehorik-category-description">
        <div class="container">
            <?= $description ?>
        </div>
    </div>
<?php endif; ?>
