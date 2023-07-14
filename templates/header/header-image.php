<?php
if (empty($args['items'])) return;
$items = $args['items'];
?>
<div class="slider-image"
     style='
     --image-large:url("<?= !empty($items['large']) ? $items['large'] : '' ?>");
     --image-small:url("<?= !empty($items['small']) ? $items['small'] : (!empty($items['large']) ? $items['large'] : '') ?>");'
></div>
<div class="slider-claim">
    <?php if (!empty($item['claim'])): ?>
        <div class="slider-title"><h1><?= $item['claim'] ?></h1></div>
    <?php endif; ?>
    <?php if (!empty($item['buttons'])): ?>
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
<?php
if (!empty($item['buttons']))
get_template_part('templates/introduction', null, [
    'text' => '<span>Hier findest Du die perfekten Geschenke für befreundete Feinschmecker:innen oder Schmankerl für verwandte Genießer:innen. Wir haben das Beste aus unseren Wein- und Delikatessenregalen geholt und schon mal ein paar Geschenke zusammengestellt.
</span><span>Mit unserem bruchsicheren Versand überleben Rehorik Weihnachtsgeschenke auch die wildeste Schlittenfahrt, direkt zu Deiner Familie, Deinen Kolleg:innen oder Freund:innen nach Hause. Das Weihnachtswichtel-Team wünscht viel Spaß beim Verschenken!</span>',
]);
?>
