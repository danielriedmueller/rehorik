<?php ?>
<li>
    <div class="frontpage-slider-image image-<?= $args['id'] ?>"></div>
    <div class="slider-claim">
        <?php if (isset($args['text'])): ?>
            <div class="slider-text"><?= $args['text'] ?></div>
        <?php endif; ?>
        <div class="slider-title"><h1><?= $args['claim'] ?></h1></div>
        <div class="button-container">
            <?php foreach ($args['buttons'] as $link => $text): ?>
                <a class="button" href="<?= $link ?>"><?= $text ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</li>
