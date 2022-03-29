<?php
$imgPathPrefix = 'url(/wp-content/themes/rehorik/assets/img/slider/';
$imgLargePathSuffix = '-1920x600px.jpg';
$imgMediumPathSuffix = '-1080x600px.jpg';
$imgSmallPathSuffix = '-375x485px.jpg';
$imgPathSuffix = ')';
?>
<ul id="slider">
    <?php foreach($args['items'] as $item): ?>
        <li>
            <div class="slider-image"
                 style='
                 --image-small:<?=$imgPathPrefix.$item['img'].$imgSmallPathSuffix.$imgPathSuffix ?>;
                 --image-medium:<?=$imgPathPrefix.$item['img'].$imgMediumPathSuffix.$imgPathSuffix ?>;
                 --image-large:<?=$imgPathPrefix.$item['img'].$imgLargePathSuffix.$imgPathSuffix ?>;
                 '
            ></div>
            <div class="slider-claim">
                <?php if (isset($item['text'])): ?>
                    <div class="auto-width slider-text"><div><?= $item['text'] ?></div></div>
                <?php endif; ?>
                <div class="slider-title"><h1><?= $item['claim'] ?></h1></div>
                <div class="auto-width button-container">
                    <div>
                        <?php foreach ($item['buttons'] as $link => $text): ?>
                            <a class="button" href="<?= $link ?>"><?= $text ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
<?php if(sizeof($args['items']) > 1): ?>
    <div id="tns-controls-container">
        <button></button>
        <button></button>
    </div>
<?php endif; ?>