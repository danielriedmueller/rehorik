<?php
add_action( 'add_meta_boxes', function () {
    function foo($post) {
        $valueFromField = get_post_meta($post->ID, 'rehorik_product_origin', true);

        $settings = array(
            'textarea_name' => 'rehorik_product_origin',
            'quicktags' => array('buttons' => 'em,strong,link'),
            'tinymce' => array(
                'theme_advanced_buttons1' => 'bold,italic,strikethrough,separator,bullist,numlist,separator,blockquote,separator,justifyleft,justifycenter,justifyright,separator,link,unlink,separator,undo,redo,separator',
                'theme_advanced_buttons2' => '',
            ),
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
        'foo',
        'product',
        'normal'
    );
});
add_action('save_post', function ($post_id) {
    update_post_meta($post_id, 'rehorik_product_origin', filter_input(INPUT_POST, 'rehorik_product_origin'));
});
