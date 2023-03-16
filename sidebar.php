<?php
//Disable sidebar on product page
if (is_product()) return;
?>

<div id="sidebar" class="rehorik-sidebar">
    <button id="product-filter-close-button">Weiter einkaufen</button>
    <?php the_widget('WC_Widget_Product_Categories', [
        'show_children_only' => false,
        'count' => false,
        'hide_empty' => true,
        'hierarchical' => true,
        'max_depth' => 3,
        'orderby' => 'order',
        'dropdown' => ['type' => 'select']
    ]);
    woocommerce_catalog_ordering();
    echo do_shortcode('[wpf-filters id=1]')
    ?>
</div>
