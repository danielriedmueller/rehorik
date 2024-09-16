<?php
if (empty($args)) return;

$small = $args[Reh_Page_Header_Image::META_HEADER_IMAGE_SMALL];
$large = $args[Reh_Page_Header_Image::META_HEADER_IMAGE_LARGE];

Reh_Page_Header_Image::isVideo($small)
?>

<?php if (Reh_Page_Header_Image::isVideo($small)): ?>
    <video data-small="<?= $small ?>" data-large="<?= $large ?>" autoplay muted loop>
        <source src="">
    </video>
<?php else: ?>
    <div class="page-header-image"
         style='--image-large:url("<?= $large ?>");--image-small:url("<?= $small ?>");'></div>
<?php endif; ?>

<div class="page-header-image"
     style='--image-large:url("<?= $imageLarge ?>");--image-small:url("<?= $imageSmall ?>");'></div>


<video data-small="<?= $videoLarge ?>" data-large="<?= $videoLarge ?>" autoplay muted loop>
    <source src="">
</video>