<?php
require_once(get_stylesheet_directory() . '/helper/video_helper.php');

/** @var WC_Product $product */
$product = $args['product'];
$video = validateVideo($product->get_meta('reh_product_video'));

?>
<div class="rehorik-product-video"><?php if(!empty($video)): ?>
    <iframe src="<?= $video ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
<?php endif; ?></div>