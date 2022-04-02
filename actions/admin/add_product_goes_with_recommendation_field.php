<?php
// Display Fields
add_action('woocommerce_product_options_general_product_data', function() {
    $id = 'reh_goes_with_recommendation';

    echo '<div>';
    woocommerce_wp_textarea_input(
        array(
            'id' => $id,
            'label' => "Passt zu"
        )
    );
    echo '</div>';
});

// Save Fields
add_action('woocommerce_process_product_meta', function($term_id) {
    $id = 'reh_goes_with_recommendation';
    update_post_meta($term_id, $id, filter_input(INPUT_POST, $id));
});