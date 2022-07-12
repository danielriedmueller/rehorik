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

    echo '</div>'; // general end
    $output = ob_get_contents(); //Grab output
    ob_end_clean(); //Discard output buffer

    return $output;
}

function getPreperationRecommendationValues($thepostid)
{
    $seperator = "|";
    $valueFromField = get_post_meta( $thepostid, 'reh_preperation_recommendation', true);

    // If seperator ist not present, its legacy value format
    if (!str_contains($valueFromField, $seperator)) {
        return getPreperationRecommendationValuesFromLegacyFormat($valueFromField);
    }

    return explode($seperator, $valueFromField);
}

/**
 * @Deprecated
 */
function getPreperationRecommendationValuesFromLegacyFormat($value)
{
    $value = strip_tags($value);
    $values = explode("Zubereitungsrezept: ", $value);
    $values[0] = str_replace("Zubereitungsempfehlung: ", "", $values[0]);
    $values[0] = str_replace("\r", "", $values[0]);
    $values[0] = str_replace("\n", "", $values[0]);

    return $values;
}

// Save Fields
add_action('woocommerce_process_product_meta', function($term_id) {
    $id = 'reh_preperation_recommendation';
    $type = filter_input(INPUT_POST, '_reh_preperation_recommendation_type');
    $recipe = filter_input(INPUT_POST, '_reh_preperation_recommendation_recipe');

    update_post_meta($term_id, $id, $type . '|' . $recipe);
});