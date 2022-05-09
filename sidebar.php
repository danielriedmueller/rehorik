<?php if (is_active_sidebar('productfilter')) : ?>
    <div id="sidebar" class="rehorik-sidebar">
        <?php the_widget('WC_Widget_Product_Categories', [
            'show_children_only' => true,
            'count' => true,
            'hide_empty' => true,
            'hierarchical' => true,
            'max_depth' => 3
        ]); ?>
    </div>
<?php endif; ?>