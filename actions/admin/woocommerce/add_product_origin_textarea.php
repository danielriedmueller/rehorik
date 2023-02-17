<?php
add_action( 'admin_enqueue_scripts', 'enqueue_gutenberg_scripts' );

function enqueue_gutenberg_scripts() {
    wp_enqueue_script( 'wp-blocks' );
    wp_enqueue_script( 'wp-editor' );
    wp_enqueue_script( 'wp-components' );
    wp_enqueue_script( 'wp-i18n' );
    wp_enqueue_style( 'wp-components' );
    wp_enqueue_style( 'wp-editor' );
}

add_action('add_meta_boxes', function () {
    function addOrigin($post)
    {
        $valueFromField = get_post_meta($post->ID, 'rehorik_product_origin', true);

        $settings = array(
            'textarea_name' => 'rehorik_product_origin',
            'editor_css' => '<style>#wp-excerpt-editor-container .wp-editor-area{height:175px; width:100%;}</style>',
        );

        wp_editor(
            htmlspecialchars_decode($valueFromField, ENT_QUOTES),
            'origin',
            apply_filters('woocommerce_product_short_description_editor_settings', $settings));
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
