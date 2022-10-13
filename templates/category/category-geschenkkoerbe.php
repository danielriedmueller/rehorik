<?php
defined('ABSPATH') || exit;

get_template_part('templates/header/head', null, [
    'slider' => [
        [
            'claim' => 'Einfach für jeden Anlass',
            'img' => 'header-geschenkkoerbe',
            'buttons' => [
                '/' => 'Etwas für unterm Baum gesucht?<br>Unser Hiliger Bimbam Geschenkkorb',
            ],
        ],
    ],
]);
get_template_part('templates/introduction', null, [
    'text' => 'NOCH NICHT DAS PASSENDE DABEI?<br>Alle Pakete im Flyer sind Vorschläge aus unserem Sortiment.<br>Natürlich erstellen wir auch Geschenke ganz nach Euren Vorstellungen –
einfach anrufen, eine Mail schreiben oder persönlich vorbeikommen.<br>Telefon 0941 / 586 52 76 oder E-Mail brixener@rehorik.de<br>
',
]);
get_template_part('templates/page-title');
?>
    <div class="container">
        <div id="main-content">
<?php
get_template_part('templates/category/content');
