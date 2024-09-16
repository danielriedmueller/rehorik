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
    private const META_HEADER_VIDEO_LARGE = 'video_large';
    private const META_HEADER_VIDEO_SMALL = 'video_small';
    const META_HEADER_CLAIM = 'claim';
    const META_HEADER_INTRO = 'intro';
    const META_HEADER_BUTTON_1 = 'button_1';
    const META_HEADER_BUTTON_2 = 'button_2';
    const META_HEADER_BUTTON_LINK = 'button_link';
    const META_HEADER_BUTTON_TEXT = 'button_text';

    const META_HEADER_SHOW_TITLE = 'show_title';

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


    public static function hasHeaderImage($headerData)
    {
        return !empty($headerData[self::META_HEADER_IMAGE_LARGE])
            || !empty($headerData[self::META_HEADER_IMAGE_SMALL])
            ;
    }

    /**
     * Either render image or video container
     *
     * Precedence: Video > Image
     *
     * @param $headerData
     * @return void
     */
    public static function render($headerData): void
    {
        $large = $headerData[Reh_Page_Header_Image::META_HEADER_IMAGE_LARGE];
        $small = $headerData[Reh_Page_Header_Image::META_HEADER_IMAGE_SMALL];

        if (empty($large)) {
            if (!empty($small)) {
                $large = $small;
            }
        }

        if (empty($small)) {
            if (!empty($large)) {
                $small = $large;
            }
        }

        if (Reh_Page_Header_Image::isVideo($small)) {
            get_template_part('templates/header/page-header-video-component', null, [Reh_Page_Header_Image::META_HEADER_IMAGE_LARGE => $large, Reh_Page_Header_Image::META_HEADER_IMAGE_SMALL => $small]);

            return;
        }

        get_template_part('templates/header/page-header-image-component', null, [Reh_Page_Header_Image::META_HEADER_IMAGE_LARGE => $large, Reh_Page_Header_Image::META_HEADER_IMAGE_SMALL => $small]);
    }

    public static function isVideo($path): bool
    {
        $videoExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'webm'];

        // Extract the file extension from the string
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (in_array($extension, $videoExtensions)) {
            return true;
        }

        return false;
    }

    public function addPageHeaderMetaBox(): void
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
            self::META_HEADER_INTRO => '',
            self::META_HEADER_BUTTON_1 => [
                self::META_HEADER_BUTTON_LINK => '',
                self::META_HEADER_BUTTON_TEXT => '',
            ],
            self::META_HEADER_BUTTON_2 => [
                self::META_HEADER_BUTTON_LINK => '',
                self::META_HEADER_BUTTON_TEXT => '',
            ],
            self::META_HEADER_SHOW_TITLE => false,
        ];
    }

    public function renderMetaBox($post): void
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

        $videoLarge = esc_attr($values[self::META_HEADER_VIDEO_LARGE] ?? '');
        $videoSmall = esc_attr($values[self::META_HEADER_VIDEO_SMALL] ?? '');

        $claim = esc_attr($values[self::META_HEADER_CLAIM] ?? '');
        $button1_link = isset($values[self::META_HEADER_BUTTON_1])
            ? $values[self::META_HEADER_BUTTON_1][self::META_HEADER_BUTTON_LINK] ?? ''
            : '';
        $button1_text = isset($values[self::META_HEADER_BUTTON_1])
            ? esc_attr($values[self::META_HEADER_BUTTON_1][self::META_HEADER_BUTTON_TEXT] ?? '')
            : '';
        $button2_link = isset($values[self::META_HEADER_BUTTON_2])
            ? $values[self::META_HEADER_BUTTON_2][self::META_HEADER_BUTTON_LINK] ?? ''
            : '';
        $button2_text = isset($values[self::META_HEADER_BUTTON_2])
            ? esc_attr($values[self::META_HEADER_BUTTON_2][self::META_HEADER_BUTTON_TEXT] ?? '')
            : '';
        $intro = esc_attr($values[self::META_HEADER_INTRO] ?? '');
        $showTitle = $values[self::META_HEADER_SHOW_TITLE] ?? false;
        ?>
        <fieldset id="page-header-form">
            <!-- Toggle checkbox for switching between images and videos -->
            <div class="toggle-container">
                <input type="checkbox" id="media-toggle" <?php  ?> />
                <label for="media-toggle" class="toggle-label"><span></span></label>

                <!-- Wrap both image and video content in a single container for sibling matching -->
                <div class="media-content-container">
                    <!-- Image Upload Section -->
                    <div class="toggle-content" id="image-content">
                        <!-- Desktop Image -->
                        <label>
                            <span>Desktop Bild (1920x600px)*</span>
                            <input
                                    type="text"
                                    id="meta-page-header-image-large"
                                    name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_IMAGE_LARGE ?>]"
                                    value="<?= $imageLarge ?>"
                                    hidden
                            />
                            <img
                                    src="<?= $imageLarge ?>"
                                    id="meta-page-header-image-preview-large"
                                    style="<?php if (empty($imageLarge)) : ?>display: none;<?php endif; ?>"
                            />
                            <button class="open-meta-image-uploader button" data-size="large">Bild auswählen</button>
                            <button
                                    id="meta-page-header-image-remove-large"
                                    class="remove-meta-image button"
                                    data-size="large"
                                    style="<?php if (empty($imageLarge)) : ?>display: none;<?php endif; ?>"
                            >Bild entfernen</button>
                        </label>

                        <!-- Mobile Image -->
                        <label>
                            <span>Mobile Bild (375x485px)*</span>
                            <input
                                    type="text"
                                    id="meta-page-header-image-small"
                                    name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_IMAGE_SMALL ?>]"
                                    value="<?= $imageSmall ?>"
                                    hidden
                            />
                            <img
                                    src="<?= $imageSmall ?>"
                                    id="meta-page-header-image-preview-small"
                                    style="<?php if (empty($imageSmall)) : ?>display: none;<?php endif; ?>"
                            />
                            <button class="open-meta-image-uploader button" data-size="small">Bild auswählen</button>
                            <button
                                    id="meta-page-header-image-remove-small"
                                    class="remove-meta-image button"
                                    data-size="small"
                                    style="<?php if (empty($imageSmall)) : ?>display: none;<?php endif; ?>"
                            >Bild entfernen</button>
                        </label>
                    </div>

                    <!-- Video Upload Section -->
                    <div class="toggle-content" id="video-content">
                        <!-- Desktop Video -->
                        <label>
                            <span>Desktop Video*</span>
                            <input
                                    type="text"
                                    id="meta-page-header-video-large"
                                    name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_VIDEO_LARGE ?>]"
                                    value="<?= $videoLarge ?>"
                                    hidden
                            />
                            <video
                                    src="<?= $videoLarge ?>"
                                    id="meta-page-header-video-preview-large"
                                    controls
                                    style="<?php if (empty($videoLarge)) : ?>display: none;<?php endif; ?>"
                            ></video>
                            <button class="open-meta-video-uploader button" data-size="large">Video auswählen</button>
                            <button
                                    id="meta-page-header-video-remove-large"
                                    class="remove-meta-video button"
                                    data-size="large"
                                    style="<?php if (empty($videoLarge)) : ?>display: none;<?php endif; ?>"
                            >Video entfernen</button>
                        </label>

                        <!-- Mobile Video -->
                        <label>
                            <span>Mobile Video*</span>
                            <input
                                    type="text"
                                    id="meta-page-header-video-small"
                                    name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_VIDEO_SMALL ?>]"
                                    value="<?= $videoSmall ?>"
                                    hidden
                            />
                            <video
                                    src="<?= $videoSmall ?>"
                                    id="meta-page-header-video-preview-small"
                                    controls
                                    style="<?php if (empty($videoSmall)) : ?>display: none;<?php endif; ?>"
                            ></video>
                            <button class="open-meta-video-uploader button" data-size="small">Video auswählen</button>
                            <button
                                    id="meta-page-header-video-remove-small"
                                    class="remove-meta-video button"
                                    data-size="small"
                                    style="<?php if (empty($videoSmall)) : ?>display: none;<?php endif; ?>"
                            >Video entfernen</button>
                        </label>
                    </div>
                </div>
            </div>
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
                       name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_BUTTON_1 ?>][<?= self::META_HEADER_BUTTON_TEXT ?>]"
                       placeholder="Text*"
                       value="<?= $button1_text ?>"
                />
                <input type="text"
                       name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_BUTTON_1 ?>][<?= self::META_HEADER_BUTTON_LINK ?>]"
                       placeholder="Link*"
                       value="<?= $button1_link ?>"
                />
            </label>
            <label>
                <span>Button #2</span>
                <input type="text"
                       name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_BUTTON_2 ?>][<?= self::META_HEADER_BUTTON_TEXT ?>]"
                       placeholder="Text*"
                       value="<?= $button2_text ?>"
                />
                <input type="text"
                       name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_BUTTON_2 ?>][<?= self::META_HEADER_BUTTON_LINK ?>]"
                       placeholder="Link*"
                       value="<?= $button2_link ?>"
                />
            </label>
            <label>
                <span>Intro</span>
                <textarea name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_INTRO ?>]"><?= $intro ?></textarea>
            </label>
            <label>
                <span>Titel anzeigen?</span>
                <input
                        type="checkbox"
                        name="<?= self::META_PAGE_HEADER ?>[<?= self::META_HEADER_SHOW_TITLE ?>]"
                        <?php if ($showTitle): ?>checked<?php endif; ?>
                >
            </label>
        </fieldset>
        <?php
    }

    public function savePageHeaderMetaBox(int $post_id)
    {
        if (!$this->validate()) {
            return;
        }

        update_post_meta($post_id, self::META_PAGE_HEADER, $this->sanitize($_POST[self::META_PAGE_HEADER]));
    }

    public function saveCatHeaderMetaBox(int $term_id)
    {
        if (!$this->validate()) {
            return;
        }

        update_term_meta($term_id, self::META_PAGE_HEADER, $this->sanitize($_POST[self::META_PAGE_HEADER]));
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

    private function sanitize($values)
    {
        $videoLarge = sanitize_text_field($values[self::META_HEADER_VIDEO_LARGE]);
        $videoSmall = sanitize_text_field($values[self::META_HEADER_VIDEO_SMALL]);

        unset($values[self::META_HEADER_VIDEO_LARGE]);
        unset($values[self::META_HEADER_VIDEO_SMALL]);

        if (!empty($videoLarge) || !empty($videoSmall)) {
            $values[self::META_HEADER_IMAGE_LARGE] = $videoLarge;
            $values[self::META_HEADER_IMAGE_SMALL] = $videoSmall;
        } else {
            $values[self::META_HEADER_IMAGE_LARGE] = sanitize_text_field($values[self::META_HEADER_IMAGE_LARGE]);
            $values[self::META_HEADER_IMAGE_SMALL] = sanitize_text_field($values[self::META_HEADER_IMAGE_SMALL]);
        }

        $values[self::META_HEADER_CLAIM] = sanitize_text_field($values[self::META_HEADER_CLAIM]);
        $values[self::META_HEADER_BUTTON_1][self::META_HEADER_BUTTON_TEXT] = sanitize_text_field($values[self::META_HEADER_BUTTON_1][self::META_HEADER_BUTTON_TEXT]);
        $values[self::META_HEADER_BUTTON_2][self::META_HEADER_BUTTON_TEXT] = sanitize_text_field($values[self::META_HEADER_BUTTON_2][self::META_HEADER_BUTTON_TEXT]);
        $values[self::META_HEADER_INTRO] = sanitize_textarea_field($values[self::META_HEADER_INTRO]);

        return $values;
    }
}

add_action('admin_init', function () {
    Reh_Page_Header_Image::instance();
});