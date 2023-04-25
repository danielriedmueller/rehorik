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
                    ['textarea_name' => 'rehorik_product_' . $key]
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
