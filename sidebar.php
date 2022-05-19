<?php
    //Disable sidebar on product page
    if (is_product()) return;
?>

<div id="sidebar" class="rehorik-sidebar">
    <?php the_widget('WC_Widget_Product_Categories', [
            'show_children_only' => true,
            'count' => true,
            'hide_empty' => false,
            'hierarchical' => true,
            'max_depth' => 3,
    ]); ?>
    <?php if (wc_get_loop_prop( 'total' ) > 0): ?>
        <h3 class="filter-title">Filter</h3>
        <?= do_shortcode('[wpf-filters id=1]') ?>
    <?php endif; ?>
</div>
