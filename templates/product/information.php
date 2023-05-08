<?php
// Product attributes manipulated by woocommerce_display_product_attributes filter
global $product;
$description = $product->get_description();
$hasDescription = !empty($description);
?>
<div class="rehorik-product-information <?php if (!$hasDescription): ?>only-attributes<?php endif; ?>">
    <?php
    the_title('<h2>', '</h2>');

    if ($hasDescription) {
        echo sprintf(
            '<div class="rehorik-product-description">%s</div>',
            apply_filters('the_content', $description)
        );
    }

    wc_display_product_attributes($product);
    ?>
</div>


