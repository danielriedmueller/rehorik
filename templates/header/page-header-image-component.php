<?php
if (empty($args)) return;

$small = Reh_Page_Video_Helper::enableAutoplay($args[Reh_Page_Header_Image::META_HEADER_IMAGE_SMALL]);
$large = Reh_Page_Video_Helper::enableAutoplay($args[Reh_Page_Header_Image::META_HEADER_IMAGE_LARGE]);
?>
<div class="page-header-image small">
    <?php if (Reh_Page_Header_Image::isLocalVideo($small)): ?>
        <video autoplay muted loop><source src="<?= $small ?>" media="(max-width: 767px)"></video>
    <?php elseif (Reh_Page_Header_Image::isYoutube($small)): ?>
        <iframe
                src="<?= $small ?>"
                frameBorder="0"
                allowFullScreen
                allow="autoplay"
        ></iframe>
    <?php else: ?>
        <div style='--image:url("<?= $small ?>");'></div>
    <?php endif; ?>
</div>
<div class="page-header-image large">
    <?php if (Reh_Page_Header_Image::isLocalVideo($large)): ?>
        <video autoplay muted loop><source src="<?= $large ?>" media="(min-width: 768px)"></video>
    <?php elseif (Reh_Page_Header_Image::isYoutube($large)): ?>
        <iframe
                src="<?= $large ?>"
                frameBorder="0"
                allowFullScreen
                allow="autoplay"
        ></iframe>
    <?php else: ?>
        <div style='--image:url("<?= $large ?>");'></div>
    <?php endif; ?>
</div>