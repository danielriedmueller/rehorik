<?php
require_once(get_stylesheet_directory() . '/helper/video_helper.php');
$video = validateVideo($args['video']);
?>
<?php if (!empty($video)): ?>
    <div class="rehorik-product-video">
            <iframe src="<?= $video ?>" title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
    </div>
<?php endif; ?>
