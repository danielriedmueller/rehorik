<?php

const ADDITIONAL_TEXTAREAS = [
    'origin' => 'Herkunft',
    'processing' => 'Aufbereitung',
];

add_action('add_meta_boxes', function () {
    foreach (ADDITIONAL_TEXTAREAS as $key => $value) {
        add_meta_box(
            'rehorik_product_' . $key,
            $value,
            function ($post) use ($key) {
                $valueFromField = get_post_meta($post->ID, 'rehorik_product_' . $key, true);
                wp_editor(
                    htmlspecialchars_decode($valueFromField, ENT_QUOTES),
                    $key,
                    [
                        'tinymce' => ['toolbar1' => 'styleselect'],
                        'textarea_name' => 'rehorik_product_' . $key,
                    ]
                );
            },
            'product',
            'normal'
        );
    }
});

add_action('save_post', function ($post_id) {
    foreach (ADDITIONAL_TEXTAREAS as $key => $value) {
        update_post_meta($post_id, 'rehorik_product_' . $key, filter_input(INPUT_POST, 'rehorik_product_' . $key));
    }
});

add_filter('tiny_mce_before_init', function (array $mceInit) {
    if (!in_array($mceInit['selector'], array_map(function ($value) {
        return '#' . $value;
    }, array_keys(ADDITIONAL_TEXTAREAS)))) {
        return $mceInit;
    }

    $style_formats = [
        [
            'title' => 'Text Links',
            'block' => 'div',
            'classes' => 'additional-text-left'
        ],
        [
            'title' => 'Text Rechts',
            'block' => 'div',
            'classes' => 'additional-text-right'
        ],
        [
            'title' => 'Bilder',
            'block' => 'div',
            'classes' => 'additional-text-images'
        ]
    ];

    $mceInit['style_formats'] = json_encode($style_formats);

    return $mceInit;
});
