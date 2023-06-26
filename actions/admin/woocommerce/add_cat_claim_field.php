<?php


add_action('product_cat_edit_form_fields', function ($term) {
    $id = 'reh_cat_claim';
    $value = get_term_meta($term, $id, true);
    echo '<div id="reh_product_title_claim_tab_data" class="panel woocommerce_options_panel">';
    woocommerce_wp_textarea_input(['value' => $value, 'id' => $id, 'label' => 'Titelzusatz']);
    echo '</div>';
});

// Save Fields
add_action('edited_product_cat', function ($term_id) {
    $id = 'reh_cat_claim';
    $value = filter_input(INPUT_POST, $id);
    update_term_meta($term_id, $id, $value);
});