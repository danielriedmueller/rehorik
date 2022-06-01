<?php
add_filter('woocommerce_product_data_tabs', function ($default_tabs) {
    $default_tabs['reh_nutrition'] = [
        'label' => 'Nährwerttabelle',
        'target' => 'reh_nutrition_tab_data',
        'priority' => 60,
        'class' => [],
    ];

    return $default_tabs;
}, 10, 1);

add_action('woocommerce_product_data_panels', function () {
    echo sprintf(
        '<div id="reh_nutrition_tab_data" class="panel woocommerce_options_panel"><fieldset><legend>Nährwerttabelle</legend>%s</fieldset><fieldset><legend>Zutatenliste / Allergene</legend><div>Hinweis: Alle Zutaten eintragen, <b>Allergene gefettet</b></div>%s</fieldset></div>',
        render_nutrition_data_fields(),
        render_ingredient_list()
    );
});

add_action('woocommerce_process_product_meta', function ($term_id) {
    $fields = define_nutrition_data_fields();

    foreach ($fields as $field => $data) {
        update_post_meta($term_id, $field, filter_input(INPUT_POST, $field));
    }

    // Add ingredients field
    update_post_meta($term_id, 'reh_ingredient_list', filter_input(INPUT_POST, 'reh_ingredient_list'));
});

add_action('admin_enqueue_scripts', function () {
    $assetsDir = get_stylesheet_directory_uri() . '/assets/';
    wp_enqueue_style('admin', $assetsDir . 'css/admin.css');
});

function render_ingredient_list()
{
    global $post;
    $field = 'reh_ingredient_list';

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

function render_nutrition_data_fields()
{
    $fields = define_nutrition_data_fields();

    ob_start();

    echo '<div class="options_group reh_nutrition_group reh_nutrition_general">'; //general start
    foreach ($fields as $id => $data) {
        $unit = (isset($data['unit'])) ? $data['unit'] : '';
        if ($data['callback'] === 'select') {
            woocommerce_wp_select(
                [
                    'id' => $id,
                    'label' => ucfirst($data['label']),
                    'options' => $data['options'],
                ]
            );
        }

        if ($data['callback'] === 'text_input') {
            woocommerce_wp_text_input(
                [
                    'id' => $id,
                    'label' => ucfirst($data['label'] . " (" . $unit . ")"),
                    'data_type' => $data['data_type'],
                ]
            );
        }
    }

    echo '</div>'; // general end
    $output = ob_get_contents(); //Grab output
    ob_end_clean(); //Discard output buffer

    return $output;
}

function define_nutrition_data_fields()
{
    $fields = [
        'reh_nutrition_reference' => [
            'label' => 'Bezugsmenge',
            'options' => [
                '100 g' => '100 g',
                '100 ml' => '100 ml',
            ],
            'callback' => 'select',
            'parent_only' => true,
        ],
        'reh_nutrition_energy' => [
            'label' => 'Brennwert / Energie',
            'data_type' => 'text',
            'unit' => 'kj / kcal',
            'callback' => 'text_input',
        ],
        'reh_nutrition_fat' => [
            'label' => 'Fett',
            'data_type' => 'decimal',
            'unit' => 'g',
            'callback' => 'text_input',
        ],
        'reh_nutrition_fat_saturated' => [
            'label' => 'Gesättigte Fettsäuren',
            'data_type' => 'decimal',
            'unit' => 'g',
            'callback' => 'text_input',
        ],
        'reh_nutrition_carbohydrates' => [
            'label' => 'Kohlenhydrate',
            'data_type' => 'decimal',
            'unit' => 'g',
            'callback' => 'text_input',
        ],
        'reh_nutrition_sugar' => [
            'label' => 'davon Zucker',
            'data_type' => 'decimal',
            'unit' => 'g',
            'callback' => 'text_input',
        ],
        'reh_nutrition_protein' => [
            'label' => 'Eiweiß',
            'data_type' => 'decimal',
            'unit' => 'g',
            'callback' => 'text_input',
        ],
        'reh_nutrition_salt' => [
            'label' => 'Salz',
            'data_type' => 'decimal',
            'unit' => 'g',
            'callback' => 'text_input',
        ],
    ];
    return $fields;
}