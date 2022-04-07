<?php
$baseDir = get_stylesheet_directory();
require_once($baseDir . '/helper/video_helper.php');

/** @var WC_Product $product */
$product = $args['product'];
$video = validateVideo($product->get_meta('reh_prod_video'));

?>
<div class="rehorik-product-video"><?php if(!empty($video)): ?>
    <iframe src="<?= $video ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
<?php endif; ?></div>