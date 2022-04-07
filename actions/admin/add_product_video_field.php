<?php
// Display Fields
add_action('woocommerce_product_options_general_product_data', function() {
    $id = 'reh_prod_video';

    echo '<div>';
    woocommerce_wp_text_input(
        array(
            'id' => $id,
            'label' => "Video"
        )
    );
    echo '</div>';
});

// Save Fields
add_action('woocommerce_process_product_meta', function($term_id) {
    $id = 'reh_prod_video';
    update_post_meta($term_id, $id, filter_input(INPUT_POST, $id));
});