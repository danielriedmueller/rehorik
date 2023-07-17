<?php

if (!defined('ABSPATH')) {
    die('-1');
}

class Reh_Page_Header_Image
{
    protected static $_instance = null;
    private $nonce = 'reh_page_header_nonce';
    const META_PAGE_HEADER = 'reh_meta_page_header';
    const META_HEADER_IMAGE_LARGE = 'image_large';
    const META_HEADER_IMAGE_SMALL = 'image_small';
    const META_HEADER_CLAIM = 'claim';
    const META_HEADER_INTRO = 'intro';
    const META_HEADER_BUTTON_1 = 'button_1';
    const META_HEADER_BUTTON_2 = 'button_2';
    const META_HEADER_BUTTON_LINK = 'button_link';
    const META_HEADER_BUTTON_TEXT = 'button_text';

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
            wp_enqueue_style('page-header', $assetsDir . 'css/page-header-admin.css', false, 1);
        });
        add_action('add_meta_boxes', [$this, 'addPageHeaderMetaBox']);
        add_action('save_post', [$this, 'savePageHeaderMetaBox']);
        add_action('product_cat_edit_form_fields', [$this, 'addCatHeaderMetaBox']);
        add_action('edited_product_cat', [$this, 'saveCatHeaderMetaBox']);
    }

    public function addPageHeaderMetaBox()
    {
        add_meta_box(
            self::META_PAGE_HEADER,
            'Headerbild',
            [$this, 'renderMetaBox'],
            'page',
            'normal',
            'high'
        );
    }

    public function addCatHeaderMetaBox($term)
    {
        $this->renderMetaBox($term);
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

        if ($post instanceof WP_Term) {
            $values = get_term_meta($post->term_id, self::META_PAGE_HEADER, true);
        } else {
            $values = get_post_meta($post->ID, self::META_PAGE_HEADER, true);
        }

        $defaults = $this->getDefaultValues();
        $values = wp_parse_args($values, $defaults);
        $imageLarge = esc_attr($values[self::META_HEADER_IMAGE_LARGE] ?? '');
        $imageSmall = esc_attr($values[self::META_HEADER_IMAGE_SMALL] ?? '');
        $claim = esc_attr($values[self::META_HEADER_CLAIM] ?? '');
        $button1_link = isset($values[self::META_HEADER_BUTTON_1])
            ? esc_attr($values[self::META_HEADER_BUTTON_1][self::META_HEADER_BUTTON_LINK] ?? '')
            : '';
        $button1_text = isset($values[self::META_HEADER_BUTTON_1])
            ? esc_attr($values[self::META_HEADER_BUTTON_1][self::META_HEADER_BUTTON_TEXT] ?? '')
            : '';
        $button2_link = isset($values[self::META_HEADER_BUTTON_2])
            ? esc_attr($values[self::META_HEADER_BUTTON_2][self::META_HEADER_BUTTON_LINK] ?? '')
            : '';
        $button2_text = isset($values[self::META_HEADER_BUTTON_2])
            ? esc_attr($values[self::META_HEADER_BUTTON_2][self::META_HEADER_BUTTON_TEXT] ?? '')
            : '';
        $intro = esc_attr($values[self::META_HEADER_INTRO] ?? '');

        ?>
        <fieldset id="page-header-form">
            <legend class="page-header-form-title">Headerbild</legend>
            <label>
                <span>Desktop (1920x600px)</span>
                <input
                    type="text"
                    id="meta-page-header-image-large"
                    name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_IMAGE_LARGE ?>]"
                    value="<?= $imageLarge ?>"
                    hidden
                />
                <button class="open-meta-image-uploader button" data-size="large">Bild auswählen</button>
                <img
                    src="<?= $imageLarge ?>"
                    id="meta-page-header-image-preview-large"
                    style="<?php if (empty($imageLarge)) : ?>display: none;<?php endif; ?>"
                />
            </label>
            <label>
                <span>Mobil (375x485px)</span>
                <input
                    type="text"
                    id="meta-page-header-image-small"
                    name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_IMAGE_SMALL ?>]"
                    value="<?= $imageSmall ?>"
                    hidden
                />
                <button class="open-meta-image-uploader button" data-size="small">Bild auswählen</button>
                <img
                    src="<?= $imageSmall ?>"
                    id="meta-page-header-image-preview-small"
                    style="<?php if (empty($imageSmall)) : ?>display: none;<?php endif; ?>"
                />
            </label>
            <label>
                <span>Claim</span>
                <input
                    type="text" name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_CLAIM ?>]"
                    value="<?= $claim ?>"
                />
            </label>
            <label>
                <span>Button #1</span>
                <input type="text"
                       name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_BUTTON_1 ?>][<?= self::META_HEADER_BUTTON_LINK ?>]"
                       placeholder="Link"
                       value="<?= $button1_link ?>"
                />
                <input type="text"
                       name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_BUTTON_1 ?>][<?= self::META_HEADER_BUTTON_TEXT ?>]"
                       placeholder="Text"
                       value="<?= $button1_text ?>"
                />
            </label>
            <label>
                <span>Button #2</span>
                <input type="text"
                       name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_BUTTON_2 ?>][<?= self::META_HEADER_BUTTON_LINK ?>]"
                       placeholder="Link"
                       value="<?= $button2_link ?>"
                />
                <input type="text"
                       name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_BUTTON_2 ?>][<?= self::META_HEADER_BUTTON_TEXT ?>]"
                       placeholder="Text"
                       value="<?= $button2_text ?>"
                />
            </label>
            <label>
                <span>Intro</span>
                <textarea name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_INTRO ?>]"><?= $intro ?></textarea>
            </label>
        </fieldset>
        <?php
    }

    public function savePageHeaderMetaBox(int $post_id)
    {
        if (!$this->validate()) {
            return;
        }

        update_post_meta($post_id, self::META_PAGE_HEADER, sanitize_text_field($_POST[self::META_PAGE_HEADER]));
    }

    public function saveCatHeaderMetaBox(int $term_id)
    {
        if (!$this->validate()) {
            return;
        }

        update_term_meta($term_id, self::META_PAGE_HEADER, sanitize_text_field($_POST[self::META_PAGE_HEADER]));
    }

    private function validate()
    {
        if (!isset($_POST[$this->nonce])) {
            return false;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return false;
        }

        if (!wp_verify_nonce($_POST[$this->nonce], $this->nonce . '_action')) {
            return false;
        }

        if (!isset($_POST[self::META_PAGE_HEADER])) {
            return false;
        }

        return true;
    }
}

add_action('admin_init', function () {
    Reh_Page_Header_Image::instance();
});