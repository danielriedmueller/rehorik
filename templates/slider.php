<?php ?>

<ul id="slider">
    <?php foreach($args['images'] as $image): ?>
        <li>
            <img src="<?= get_stylesheet_directory_uri() . $image ?>" />
        </li>
    <?php endforeach; ?>
</ul>
<div id="tns-controls-container">
    <button></button>
    <button></button>
</div>
