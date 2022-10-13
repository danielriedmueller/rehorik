<?php
defined('ABSPATH') || exit;

get_template_part('templates/header/head', null, [
    'slider' => [
        [
            'claim' => 'Einfach für jeden Anlass',
            'img' => 'header-geschenkkoerbe',
            'buttons' => [
                '/' => 'TODO',
            ],
        ],
    ],
]);
get_template_part('templates/introduction', null, [
    'text' => 'NOCH NICHT DAS PASSENDE DABEI??<br>Alle Pakete im Flyer sind Vorschläge aus unserem Sortiment. Natür-
lich erstellen wir auch Geschenke ganz nach Euren Vorstellungen –
einfach anrufen, eine Mail schreiben oder persönlich vorbeikommen.<br>Telefon 0941 / 586 52 76 ODER E-Mail brixener@rehorik.de<br>
UM EUCH DEN BESTEN SERVICE ZU BIETEN,
BEACHTET BITTE FOLGENDES:
<ul>
    <li>Individuell gesteckte Geschenkkörbe ab 80€ nur auf Vorbestellung und mit 2 Tagen Vorlauf</li>
    <li>Aufträge, die per Post verschickt werden, benötigen von der Bearbeitung bis zur
    Zustellung circa 5 Werktage.</li>
    <li>Gesteckte Geschenkkörbe können nicht per Post verschickt werden. In diesem Fall
    wird die Ware bruchsicher in einen Geschenkkarton verpackt.</li>
    <li>Die angegebenen Preise sind freibleibend.</li>
</ul>',
]);
get_template_part('templates/page-title');
?>
    <div class="container">
        <div id="main-content">
<?php
get_template_part('templates/category/content');
