<?php
add_filter('woocommerce_product_data_tabs', function ($default_tabs) {
    $default_tabs['reh_preperation_recommendation'] = [
        'label' => 'Zubereitungsempfehlung',
        'target' => 'reh_preperation_recommendation_tab_data',
        'priority' => 60,
        'class' => [],
    ];

    return $default_tabs;
}, 10, 1);

add_action('woocommerce_product_data_panels', function () {
    echo sprintf(
        '<div id="reh_preperation_recommendation_tab_data" class="panel woocommerce_options_panel"><fieldset><legend>Zubereitungsempfehlung</legend>%s</fieldset></div>',
        render_preperation_recommendation_field(),
    );
});

function render_preperation_recommendation_field()
{
    global $post;
    $field = 'reh_preperation_recommendation';

    $content = get_post_meta( $post->ID, $field, true );

    ob_start();
    wp_editor(
        $content,
        $field,
        [
            'media_buttons' => false,
            'textarea_rows' => 12,
            'tinymce' => [
                'theme_advanced_buttons1' => 'bold',
                'theme_advanced_buttons2' => '',
                'theme_advanced_buttons3' => '',
                'theme_advanced_buttons4' => '',
            ],
        ]);

    $output = ob_get_contents(); //Grab output
    ob_end_clean(); //Discard output buffer

    return $output;
}

// Save Fields
add_action('woocommerce_process_product_meta', function($term_id) {
    $id = 'reh_preperation_recommendation';
    update_post_meta($term_id, $id, filter_input(INPUT_POST, $id));
});