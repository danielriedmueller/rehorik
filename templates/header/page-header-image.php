<?php
if (empty($args['data'])) return;
$data = $args['data'];

if (!Reh_Page_Header_Image::hasHeaderImage($data)) {
    return;
}

$claim = $data[Reh_Page_Header_Image::META_HEADER_CLAIM];
$button_1_link = isset($data[Reh_Page_Header_Image::META_HEADER_BUTTON_1]) ? (!empty($data[Reh_Page_Header_Image::META_HEADER_BUTTON_1][Reh_Page_Header_Image::META_HEADER_BUTTON_LINK]) ? $data[Reh_Page_Header_Image::META_HEADER_BUTTON_1][Reh_Page_Header_Image::META_HEADER_BUTTON_LINK] : '') : '';
$button_1_text = isset($data[Reh_Page_Header_Image::META_HEADER_BUTTON_1]) ? (!empty($data[Reh_Page_Header_Image::META_HEADER_BUTTON_1][Reh_Page_Header_Image::META_HEADER_BUTTON_TEXT]) ? $data[Reh_Page_Header_Image::META_HEADER_BUTTON_1][Reh_Page_Header_Image::META_HEADER_BUTTON_TEXT] : '') : '';
$hasButton_1 = !empty($button_1_link) && !empty($button_1_text);
$button_2_link = isset($data[Reh_Page_Header_Image::META_HEADER_BUTTON_2]) ? (!empty($data[Reh_Page_Header_Image::META_HEADER_BUTTON_2][Reh_Page_Header_Image::META_HEADER_BUTTON_LINK]) ? $data[Reh_Page_Header_Image::META_HEADER_BUTTON_2][Reh_Page_Header_Image::META_HEADER_BUTTON_LINK] : '') : '';
$button_2_text = isset($data[Reh_Page_Header_Image::META_HEADER_BUTTON_2]) ? (!empty($data[Reh_Page_Header_Image::META_HEADER_BUTTON_2][Reh_Page_Header_Image::META_HEADER_BUTTON_TEXT]) ? $data[Reh_Page_Header_Image::META_HEADER_BUTTON_2][Reh_Page_Header_Image::META_HEADER_BUTTON_TEXT] : '') : '';
$hasButton_2 = !empty($button_2_link) && !empty($button_2_text);

?>
<div id="page-header-image-outer">
    <?php Reh_Page_Header_Image::renderImageComponent($data); ?>
    <div class="page-header-claim">
        <?php if (!empty($claim)): ?>
            <div class="page-header-title"><h1><?= $claim ?></h1></div>
        <?php endif; ?>
        <?php if ($hasButton_1 || $hasButton_2): ?>
            <div class="button-container">
                <?php if ($hasButton_1): ?>
                    <a class="button" href="<?= $button_1_link ?>"><?= $button_1_text ?></a>
                <?php endif; ?>
                <?php if ($hasButton_2): ?>
                    <a class="button" href="<?= $button_2_link ?>"><?= $button_2_text ?></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
