<?php
if (empty($args)) return;

$small = $args[Reh_Page_Header_Image::META_HEADER_IMAGE_SMALL];
$large = $args[Reh_Page_Header_Image::META_HEADER_IMAGE_LARGE];

?>
<div class="page-header-image small">
    <?php if (Reh_Page_Header_Image::isVideo($small)): ?>
        <video autoplay muted loop><source src="<?= $small ?>" media="(max-width: 767px)"></video>
    <?php else: ?>
        <div style='--image:url("<?= $small ?>");'></div>
    <?php endif; ?>
</div>
<div class="page-header-image large">
    <?php if (Reh_Page_Header_Image::isVideo($large)): ?>
        <video autoplay muted loop><source src="<?= $large ?>" media="(min-width: 768px)"></video>
    <?php else: ?>
        <div style='--image:url("<?= $large ?>");'></div>
    <?php endif; ?>
</div>