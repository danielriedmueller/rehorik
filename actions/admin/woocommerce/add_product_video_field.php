<?php
add_filter('woocommerce_product_data_tabs', function ($default_tabs) {
    $default_tabs['reh_product_video'] = [
        'label' => 'Produktvideo',
        'target' => 'reh_product_video_tab_data',
        'priority' => 60,
        'class' => [],
    ];

    return $default_tabs;
}, 10, 1);

add_action('woocommerce_product_data_panels', function () {
    $id = 'reh_product_video';
    echo '<div id="reh_product_video_tab_data" class="panel woocommerce_options_panel">';
    woocommerce_wp_text_input(['id' => $id, 'label' => 'Produktvideo']);
    echo '</div>';
});

// Save Fields
add_action('woocommerce_process_product_meta', function ($term_id) {
    $id = 'reh_product_video';
    update_post_meta($term_id, $id, filter_input(INPUT_POST, $id));
});