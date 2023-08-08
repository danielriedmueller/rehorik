<?php $sigils = getSigils($args['product']); ?>
<?php if (!empty($sigils)): ?>
    <div class="sigil-container">
        <?php
        foreach ($sigils as $sigil) {
            echo sprintf('<div title="%s" class="%s">%s</div>', $sigil['title'], $sigil['class'], $sigil['text']);
        }
        ?>
    </div>
<?php endif; ?>