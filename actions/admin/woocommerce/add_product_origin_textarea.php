<?php
add_action('admin_enqueue_scripts', 'enqueue_gutenberg_scripts');

function enqueue_gutenberg_scripts()
{
    wp_enqueue_script('wp-blocks');
    wp_enqueue_script('wp-editor');
    wp_enqueue_script('wp-components');
    wp_enqueue_script('wp-i18n');
    wp_enqueue_style('wp-components');
    wp_enqueue_style('wp-editor');
}

add_action('add_meta_boxes', function () {
    function addOrigin($post)
    {
        $valueFromField = get_post_meta($post->ID, 'rehorik_product_origin', true);
        wp_editor(
            htmlspecialchars_decode($valueFromField, ENT_QUOTES),
            'origin',
            [
                'tinymce' => array(
                    // Items for the Visual Tab
                    'toolbar1' => 'styleselect',
                ),
                'textarea_name' => 'rehorik_product_origin',
            ]
        );
    }

    add_meta_box(
        'rehorik_product_origin',
        'Herkunft',
        'addOrigin',
        'product',
        'normal'
    );
});

add_action('save_post', function ($post_id) {
    update_post_meta($post_id, 'rehorik_product_origin', filter_input(INPUT_POST, 'rehorik_product_origin'));
});

add_filter('tiny_mce_before_init', function (array $mceInit) {
    if ($mceInit['selector'] !== '#origin') {
        return $mceInit;
    }

    $style_formats = [
        [
            'title' => 'Text Links',
            'block' => 'div',
            'classes' => 'origin-text-left'
        ],
        [
            'title' => 'Text Rechts',
            'block' => 'div',
            'classes' => 'origin-text-right'
        ],
        [
            'title' => 'Bilder',
            'block' => 'div',
            'classes' => 'origin-images'
        ]
    ];

    $mceInit['style_formats'] = json_encode($style_formats);

    return $mceInit;
});
