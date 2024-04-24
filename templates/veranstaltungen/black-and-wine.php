<?php ?>
<div id="special-category">
    <?php
	$page_id = 42403;
	$page = get_post($page_id);
	if ($page) {
		$content = apply_filters('the_content', $page->post_content);
		echo $content;
	}
    ?>
    <div class="flex-images mt">
        <div><img alt="Black & Wine 1"
                  src="<?= get_stylesheet_directory_uri() . '/assets/img/veranstaltungen/blackandwine/bw-1.jpg' ?>">
        </div>
        <div><img alt="Black & Wine 2"
                  src="<?= get_stylesheet_directory_uri() . '/assets/img/veranstaltungen/blackandwine/bw-2.jpg' ?>">
        </div>
        <div><img alt="Black & Wine 3"
                  src="<?= get_stylesheet_directory_uri() . '/assets/img/veranstaltungen/blackandwine/bw-3.jpg' ?>">
        </div>
    </div>
</div>
