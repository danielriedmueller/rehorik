<?php ?>
<li>
    <div class="frontpage-slider-image image-<?= $args['id'] ?>"></div>
    <div class="slider-claim">
        <?php if (isset($args['text'])): ?>
            <div class="auto-width slider-text"><div><?= $args['text'] ?></div></div>
        <?php endif; ?>
        <div class="slider-title"><h2><?= $args['claim'] ?></h2></div>
        <div class="auto-width button-container">
            <div>
                <?php foreach ($args['buttons'] as $link => $text): ?>
                    <a class="button" href="<?= $link ?>"><?= $text ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</li>
