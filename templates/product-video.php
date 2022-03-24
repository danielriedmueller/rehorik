<?php
/** @var WC_Product $product */
$product = $args['product'];
$video = $product->get_meta('Video')
?>
<div class="rehorik-product-video">
    <iframe src="<?= $video ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>