<?php
$imgPathPrefix = 'url(/wp-content/themes/rehorik/assets/img/slider/';
$imgLargePathSuffix = '-1920x600px.jpg';
$imgMediumPathSuffix = '-1080x600px.jpg';
$imgSmallPathSuffix = '-375x485px.jpg';
$imgPathSuffix = ')';
?>
<div id="slider">
    <?php if (sizeof($args['items']) > 1) : ?>
        <ul id="slider-content">
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
                        <?php if (isset($item['claim'])): ?>
                            <?php if (isset($item['primary']) && $item['primary']): ?>
                                <div class="slider-title"><h1><?= $item['claim'] ?></h1></div>
                            <?php else: ?>
                                <div class="slider-title"><h2><?= $item['claim'] ?></h2></div>
                            <?php endif; ?>
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
                </li>
            <?php endforeach; ?>
        </ul>
        <div id="tns-controls-container">
            <button></button>
            <button></button>
        </div>
    <?php endif; ?>
    <?php if (sizeof($args['items']) === 1) : ?>
        <?php $item = $args['items'][0]; ?>
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
                <?php if (isset($item['claim'])): ?>
                    <div class="slider-title"><h2><?= $item['claim'] ?></h2></div>
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
    <?php endif; ?>
</div>
<a id="rehorik-logo" href="<?php echo get_home_url(); ?>"></a>

