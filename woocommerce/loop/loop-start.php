<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$subcategories = null;
$taxonomy = 'product_cat';
if (is_product_category() || is_shop()) {
    $term_id = get_queried_object_id();
    $subcategories = woocommerce_get_product_subcategories($term_id);
}

?>
<?php if (!empty($subcategories)) : ?>
    <div class="rehorik-products-subcategories-outer">
        <ul class="rehorik-products-subcategories">
            <?php foreach ($subcategories as $term) : ?>
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
<ul class="rehorik-products products">
