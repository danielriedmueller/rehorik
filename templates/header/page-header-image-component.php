<?php
if (empty($args)) return;

$small = Reh_Page_Video_Helper::sanitizeVideo($args[Reh_Page_Header_Image::META_HEADER_IMAGE_SMALL]);
$large = Reh_Page_Video_Helper::sanitizeVideo($args[Reh_Page_Header_Image::META_HEADER_IMAGE_LARGE]);
?>
<div class="page-header-image small">
    <?php if (Reh_Page_Video_Helper::isLocalVideo($small)): ?>
        <video autoplay muted loop playsinline><source src="<?= $small ?>" media="(max-width: 767px)"></video>
    <?php else: ?>
        <div style='--image:url("<?= $small ?>");'></div>
    <?php endif; ?>
</div>
<div class="page-header-image large">
    <?php if (Reh_Page_Video_Helper::isLocalVideo($large)): ?>
        <video autoplay muted loop playsinline><source src="<?= $large ?>" media="(min-width: 768px)"></video>
    <?php else: ?>
        <div style='--image:url("<?= $large ?>");'></div>
    <?php endif; ?>
</div>