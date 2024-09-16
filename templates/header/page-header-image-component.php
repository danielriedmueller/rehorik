<?php
if (empty($args)) return;

$imageSmall = $args[Reh_Page_Header_Image::META_HEADER_IMAGE_SMALL];
$imageLarge = $args[Reh_Page_Header_Image::META_HEADER_IMAGE_LARGE];
?>

<div class="page-header-image"
     style='--image-large:url("<?= $imageLarge ?>");--image-small:url("<?= $imageSmall ?>");'></div>
