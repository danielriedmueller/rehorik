<?php

if (!defined('ABSPATH')) {
    die('-1');
}

class Reh_Page_Header
{
    protected static $_instance = null;
    private $nonce = 'reh_page_header_nonce';
    const META_PAGE_HEADER = 'reh_meta_page_header';
    const META_HEADER_IMAGE_LARGE = 'image_large';
    const META_HEADER_IMAGE_SMALL = 'image_small';
    const META_HEADER_CLAIM = 'claim';

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
    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        add_action('admin_enqueue_scripts', function () {
            $assetsDir = get_stylesheet_directory_uri() . '/assets/';
            wp_enqueue_script('page-header', $assetsDir . 'js/page_header.js', ['jquery'], 1, true);
        });
        add_action('add_meta_boxes', [$this, 'addPageHeaderMetaBox']);
        add_action('save_post', [$this, 'savePageHeaderMetaBox']);
    }

    public function addPageHeaderMetaBox()
    {
        add_meta_box(
            self::META_PAGE_HEADER,
            'Page Header',
            [$this, 'renderMetaBox'],
            'page',
            'side'
        );
    }

    private function getDefaultValues()
    {
        return [
            self::META_HEADER_IMAGE_LARGE => '',
            self::META_HEADER_IMAGE_SMALL => '',
            self::META_HEADER_CLAIM => '',
        ];
    }

    public function renderMetaBox($post)
    {
        wp_nonce_field($this->nonce . '_action', $this->nonce);
        $values = get_post_meta($post->ID, self::META_PAGE_HEADER, true);
        $defaults = $this->getDefaultValues();
        $values = wp_parse_args($values, $defaults);
        ?>
            <fieldset>
                <div>
                    <label for="meta-page-header-image-large">Desktop (1920x600px)</label>
                    <input type="text" name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_IMAGE_LARGE ?>]"
                           id="meta-page-header-image-large"
                           value="<?= esc_attr($values[self::META_HEADER_IMAGE_LARGE]); ?>" hidden/>
                    <img
                        id="meta-page-header-image-preview-large"
                        src="<?php echo esc_attr($values[self::META_HEADER_IMAGE_LARGE]); ?>"
                        style="<?php if(empty($values[self::META_HEADER_IMAGE_LARGE])) : ?>display: none;<?php endif; ?>"
                    />
                    <button class="open-meta-image-uploader button" data-size="large">Bild auswählen</button>
                </div>
                <div>
                    <label for="meta-page-header-image-small">Mobil (375x485px)</label>
                    <input type="text" name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_IMAGE_SMALL ?>]"
                           id="meta-page-header-image-small"
                           value="<?= esc_attr($values[self::META_HEADER_IMAGE_SMALL]); ?>" hidden/>
                    <img
                        id="meta-page-header-image-preview-small"
                        src="<?php echo esc_attr($values[self::META_HEADER_IMAGE_SMALL]); ?>"
                        style="<?php if(empty($values[self::META_HEADER_IMAGE_SMALL])) : ?>display: none;<?php endif; ?>"
                    />
                    <button class="open-meta-image-uploader button" data-size="small">Bild auswählen</button>
                </div>
                <div>
                    <label for="meta-page-header-claim">Claim</label>
                    <input type="text" name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_CLAIM ?>]"
                           id="meta-page-header-claim"
                           value="<?= esc_attr($values[self::META_HEADER_CLAIM]); ?>"/>
                </div>
            </fieldset>
        <?php
    }

    public function savePageHeaderMetaBox(int $post_id)
    {
        // Check if our nonce is set.
        if (!isset($_POST[$this->nonce])) {
            return;
        }

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($_POST[$this->nonce], $this->nonce . '_action')) {
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
        if (!isset($_POST[self::META_PAGE_HEADER])) {
            return;
        }

        $value = sanitize_text_field($_POST[self::META_PAGE_HEADER]);

        // Update the meta field in the database.
        update_post_meta($post_id, self::META_PAGE_HEADER, $value);
    }
}

add_action('admin_init', function () {
    Reh_Page_Header::instance();
});