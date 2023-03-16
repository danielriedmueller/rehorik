<?php
$subcategories = null;
$taxonomy = 'product_cat';
if (is_product_category() || is_shop()) {
    $cats = woocommerce_get_product_subcategories(get_queried_object_id());
    if (empty($cats)) {
        $cats = array_filter(woocommerce_get_product_subcategories(get_queried_object()->parent), function ($cat) {
            return $cat->term_id !== get_queried_object_id();
        });
    }
}
?>
<?php if (!empty($cats)) : ?>
    <div class="rehorik-products-subcategories-outer">
        <ul class="rehorik-products-subcategories">
            <?php foreach ($cats as $term) : ?>
                <li class="rehorik-product-subcategory product-category product">
                    <a href="<?php echo get_term_link($term, $taxonomy); ?>">
                        <?php
                        woocommerce_subcategory_thumbnail($term);
                        woocommerce_template_loop_category_title($term);
                        ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
