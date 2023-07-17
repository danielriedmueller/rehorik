<?php
if (empty($args['data'])) return;
$data = $args['data'];
$imageLarge = !empty($data[Reh_Page_Header_Image::META_HEADER_IMAGE_LARGE]) ? $data[Reh_Page_Header_Image::META_HEADER_IMAGE_LARGE] : '';
$imageSmall = !empty($data[Reh_Page_Header_Image::META_HEADER_IMAGE_SMALL]) ? $data[Reh_Page_Header_Image::META_HEADER_IMAGE_SMALL] : (!empty($data[Reh_Page_Header_Image::META_HEADER_IMAGE_LARGE]) ? $data[Reh_Page_Header_Image::META_HEADER_IMAGE_LARGE] : '');
$claim = $data[Reh_Page_Header_Image::META_HEADER_CLAIM];
$button_1 = $data[Reh_Page_Header_Image::META_HEADER_BUTTON_1];
$button_2 = $data[Reh_Page_Header_Image::META_HEADER_BUTTON_2];

?>
<div id="page-header-image-outer">
    <div class="page-header-image"
         style='--image-large:url("<?= $imageLarge ?>");--image-small:url("<?= $imageSmall ?>");'></div>
    <div class="page-header-claim">
        <?php if (!empty($claim)): ?>
            <div class="page-header-title"><h1><?= $claim ?></h1></div>
        <?php endif; ?>
        <?php if (!empty($button_1) || !empty($button_2)): ?>
            <div class="auto-width button-container">
                <div>
                    <?php if (!empty($button_1)): ?>
                        <a class="button" href="<?= $button_1[Reh_Page_Header_Image::META_HEADER_BUTTON_LINK] ?>">
                            <?= $button_1[Reh_Page_Header_Image::META_HEADER_BUTTON_TEXT] ?>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($button_2)): ?>
                        <a class="button" href="<?= $button_2[Reh_Page_Header_Image::META_HEADER_BUTTON_LINK] ?>">
                            <?= $button_2[Reh_Page_Header_Image::META_HEADER_BUTTON_TEXT] ?>
                        </a>
                    <?php endif; ?>
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
</div>
