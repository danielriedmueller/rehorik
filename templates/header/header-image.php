<?php
if (empty($args['data'])) return;
$data = $args['data'];
$imageLarge = !empty($data[Reh_Page_Header::META_HEADER_IMAGE_LARGE]) ? $data[Reh_Page_Header::META_HEADER_IMAGE_LARGE] : '';
$imageSmall = !empty($data[Reh_Page_Header::META_HEADER_IMAGE_SMALL]) ? $data[Reh_Page_Header::META_HEADER_IMAGE_SMALL] : (!empty($data[Reh_Page_Header::META_HEADER_IMAGE_LARGE]) ? $data[Reh_Page_Header::META_HEADER_IMAGE_LARGE] : '');
$claim = $data[Reh_Page_Header::META_HEADER_CLAIM];

?>
<div class="slider-image" style='--image-large:url("<?= $imageLarge ?>");--image-small:url("<?= $imageSmall ?>");'></div>
<div class="slider-claim">
    <?php if (!empty($claim)): ?>
        <div class="slider-title"><h1><?= $claim ?></h1></div>
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
<?php
if (!empty($item['buttons']))
get_template_part('templates/introduction', null, [
    'text' => '<span>Hier findest Du die perfekten Geschenke für befreundete Feinschmecker:innen oder Schmankerl für verwandte Genießer:innen. Wir haben das Beste aus unseren Wein- und Delikatessenregalen geholt und schon mal ein paar Geschenke zusammengestellt.
</span><span>Mit unserem bruchsicheren Versand überleben Rehorik Weihnachtsgeschenke auch die wildeste Schlittenfahrt, direkt zu Deiner Familie, Deinen Kolleg:innen oder Freund:innen nach Hause. Das Weihnachtswichtel-Team wünscht viel Spaß beim Verschenken!</span>',
]);
?>
