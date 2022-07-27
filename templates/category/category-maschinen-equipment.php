<?php
defined( 'ABSPATH' ) || exit;

$slider = [
    'claim' => 'Werdet zum Home Barista und holt Euch Eure Lieblingsmaschine!',
    'img' => 'header-maschinen',
    'buttons' => [
        'mailto:<?= BARISTASTORE_EMAIL ?>?subject=Beratungstermin%20Maschinen%20und%20Equipment' => 'Beratungstermin vereinbaren'
    ]
];
get_template_part('templates/header/head', null, ['slider' => [$slider]]);
get_template_part('templates/page-title');

?>
    <div class="container">
        <div id="main-content">
<?php
get_template_part('templates/category/content');
