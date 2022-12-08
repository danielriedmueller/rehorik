<?php
defined('ABSPATH') || exit;

get_template_part('templates/header/head', null, [
    'slider' => [
        [
            'claim' => 'Genuss zum Verschenken oder Selbsteinlösen!',
            'img' => 'header-gutscheine',
        ],
    ],
]);
get_template_part('templates/introduction', null, [
    'text' => 'Zum Selbstausdrucken. Für Veranstaltungen, Kaffee und alle Produkte, die sich hier so finden lassen.<br>Noch ein Hinweis: Die Onlinegutscheine sind nur im Onlineshop einlösbar. An unseren Standorten kann man mit den Onlinegutscheinen noch nicht shoppen.',
]);
get_template_part('templates/page-title');
?>
    <div class="container">
        <div id="main-content">
<?php
get_template_part('templates/category/content');
?>