<?php
defined('ABSPATH') || exit;

get_template_part('templates/header/head', null, [
    'slider' => [
        [
            'claim' => 'Einfach für jeden Anlass',
            'img' => 'header-geschenkkoerbe',
            'buttons' => [
                'produkt/heiliger-bimbam' => 'Etwas für unterm Baum gesucht?<br>Hiliger Bimbam',
            ],
        ],
    ],
]);
get_template_part('templates/introduction', null, [
    'text' => '<span>NOCH NICHT DAS PASSENDE DABEI?<br>Alle Pakete im Flyer sind Vorschläge aus unserem Sortiment.<br>Natürlich erstellen wir auch Geschenke ganz nach Euren Vorstellungen –
einfach anrufen, eine Mail schreiben oder persönlich vorbeikommen.<br>Telefon <a href="tel:0941 / 586 52 76">0941 / 586 52 76</a> oder E-Mail an <a href="mailto:brixener@rehorik.de">brixener@rehorik.de</a>.<br>Der Verpackungsaufwand ist höher, deswegen müssen wir leider 2€ mehr Versand aufschlagen.
</span>',
]);
get_template_part('templates/page-title');
?>
    <div class="container">
        <div id="main-content">
<?php
get_template_part('templates/category/content');
