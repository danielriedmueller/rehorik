<?php
    //Disable sidebar on product page
    if (is_product()) return;
?>

<div id="sidebar" class="rehorik-sidebar">
    <button id="product-filter-close-button"></button>
    <?php the_widget('WC_Widget_Product_Categories', [
            'show_children_only' => false,
            'count' => false,
            'hide_empty' => true,
            'hierarchical' => true,
            'max_depth' => 3,
            'orderby' => 'order',
            'dropdown' => ['type' => 'select']
    ]);
    echo '<div class="rehorik-result-count-and-ordering">';
    woocommerce_result_count();
    woocommerce_catalog_ordering();
    echo '</div>';
    if (wc_get_loop_prop( 'total' ) > 0): ?>
        <?= do_shortcode('[wpf-filters id=1]') ?>
    <?php endif; ?>
</div>
