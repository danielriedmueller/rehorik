<?php
if (empty($args['items'])) return;
$items = $args['items'];
?>
<div class="slider-image"
     style='
     <?php if (isset($items['large'])): ?>--image-large:<?= $items['large'] ?>;<?php endif; ?>
     <?php if (isset($items['medium'])): ?>--image-large:<?= $items['medium'] ?>;<?php endif; ?>
     <?php if (isset($items['small'])): ?>--image-large:<?= $items['small'] ?>;<?php endif; ?>
         '
></div>
<div class="slider-claim">
    <?php if (isset($item['claim'])): ?>
        <div class="slider-title"><h1><?= $item['claim'] ?></h1></div>
    <?php endif; ?>
    <?php if (isset($item['buttons'])): ?>
        <div class="auto-width button-container">
            <div>
                <?php foreach ($item['buttons'] as $link => $text): ?>
                    <a class="button" href="<?= $link ?>"><?= $text ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<a id="rehorik-logo" href="<?php echo get_home_url(); ?>"></a>
