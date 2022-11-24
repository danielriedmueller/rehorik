<?php
defined('ABSPATH') || exit;

get_template_part('templates/header/head', null, [
    'slider' => [
        [
            'claim' => 'Zum Verschenken oder Selbsteinlösen!',
            'img' => 'header-gutscheine',
        ],
    ],
]);
get_template_part('templates/introduction', null, [
    'text' => 'Unsere Onlinegutscheine sind einlösbar für alle Veranstaltungen und allen Produkten, die sich hier so finden lassen.<br>Noch ein Hinweis: Die Onlinegutscheine sind nur im Onlineshop einlösbar.<br>An unseren Standorten kann man mit den Onlinegutscheinen leider noch nicht shoppen gehen.',
]);
get_template_part('templates/page-title');
?>
    <div class="container">
        <div id="main-content">
<?php
get_template_part('templates/category/content');
?>
