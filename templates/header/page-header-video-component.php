<?php
if (empty($args)) return;

$videoSmall = $args[Reh_Page_Header_Image::META_HEADER_IMAGE_SMALL];
$videoLarge = $args[Reh_Page_Header_Image::META_HEADER_IMAGE_LARGE];
?>

<video data-small="<?= $videoLarge ?>" data-large="<?= $videoLarge ?>" autoplay muted loop>
    <source src="">
</video>