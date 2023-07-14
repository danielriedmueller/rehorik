<?php

if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

class Reh_Page_Header
{
    protected static $_instance = null;
    private $nonce = 'reh_page_header_nonce';
    const META_HEADER_IMAGE_LARGE = 'reh_page_header_large';
    const META_HEADER_IMAGE_SMALL = 'reh_page_header_small';
    const META_HEADER_CLAIM = 'reh_page_header_claim';

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @throws Exception
     */
    public function __construct() {
        $this->init();
    }

    public function init() {
        add_action('admin_enqueue_scripts', function () {
            $assetsDir = get_stylesheet_directory_uri() . '/assets/';
            wp_enqueue_script('page-header', $assetsDir . 'js/page_header.js', ['jquery'], 1, true);
        });
        add_action('add_meta_boxes', [$this, 'addPageHeaderMetaBox']);
        add_action('save_post', [$this, 'savePageHeaderMetaBox']);
    }

    public function addPageHeaderMetaBox() {
        add_meta_box(
            self::META_HEADER_IMAGE_LARGE,
            'Page Header',
            [$this, 'pageHeaderMetaBox'],
            'page',
            'side'
        );
    }

    public function pageHeaderMetaBox($post) {
        wp_nonce_field( $this->nonce . '_action', $this->nonce );
        $metaImageURL = get_post_meta($post->ID, self::META_HEADER_IMAGE_LARGE, true);

        // Output the custom meta field HTML
        ?>
        <div class="your-meta-field-wrapper">
            <label for="meta-image-url">Meta Image URL</label>
            <input type="text" id="meta-image-url" name="<?= self::META_HEADER_IMAGE_LARGE ?>" value="<?= esc_attr($metaImageURL); ?>" readonly />

            <img id="meta-image-preview" src="<?php echo esc_attr($metaImageURL); ?>" alt="Meta Image Preview" style="max-width: 200px; height: auto;" />

            <button id="open-meta-image-uploader" class="button">Choose Image</button>
        </div>
        <?php
    }

    public function savePageHeaderMetaBox(int $post_id) {
        // Check if our nonce is set.
        if (!isset($_POST[$this->nonce])) {
            return;
        }

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($_POST[$this->nonce], $this->nonce. '_action')) {
            return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check the user's permissions.
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Make sure that it is set.
        if (!isset($_POST[self::META_HEADER_IMAGE_LARGE])) {
            return;
        }

        // Sanitize user input.
        $my_data = sanitize_text_field($_POST[self::META_HEADER_IMAGE_LARGE]);

        // Update the meta field in the database.
        update_post_meta($post_id, self::META_HEADER_IMAGE_LARGE, $my_data);
    }
}

add_action( 'admin_init', function () {
    Reh_Page_Header::instance();
});