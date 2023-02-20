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

function render_preperation_recommendation_field(): string
{
    global $thepostid;
    $values = getPreperationRecommendationValues($thepostid);

    ob_start();
    echo '<div>'; //general start
    woocommerce_wp_text_input(
        [
            'id' => '_reh_preperation_recommendation_type',
            'label' => "Typ",
            'value' => $values[0] ?? ""
        ]
    );
    woocommerce_wp_textarea_input(
        [
            'id' => '_reh_preperation_recommendation_recipe',
            'label' => "Rezept",
            'value' => $values[1] ?? ""
        ]
    );
    woocommerce_wp_text_input(
        [
            'id' => '_reh_preperation_recommendation_video',
            'label' => "Video",
            'value' => $values[2] ?? ""
        ]
    );

    echo '</div>'; // general end
    $output = ob_get_contents(); //Grab output
    ob_end_clean(); //Discard output buffer

    return $output;
}

function getPreperationRecommendationValues($thepostid): array
{
    $seperator = "|";
    $valueFromField = get_post_meta( $thepostid, 'reh_preperation_recommendation', true);

    return explode($seperator, $valueFromField);
}

// Save Fields
add_action('woocommerce_process_product_meta', function($term_id): void {
    $id = 'reh_preperation_recommendation';
    $type = filter_input(INPUT_POST, '_reh_preperation_recommendation_type');
    $recipe = filter_input(INPUT_POST, '_reh_preperation_recommendation_recipe');
    $video = filter_input(INPUT_POST, '_reh_preperation_recommendation_video');

    update_post_meta($term_id, $id, $type . '|' . $recipe . '|' . $video);
});
