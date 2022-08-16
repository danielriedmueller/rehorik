<?php
defined( 'ABSPATH' ) || exit;

$slider = [
    'claim' => 'Werdet zum Home Barista und holt Euch Eure Lieblingsmaschine!',
    'img' => 'header-maschinen',
    'buttons' => [
        'mailto:' . BARISTASTORE_EMAIL . '?subject=Maschinenberatung&body=Hallo%20Rehorik-Team,%0D%0A%0D%0AHIER%20STEHT%20DEINE%20NACHRICHT"' => 'Beratungstermin vereinbaren'
    ]
];
get_template_part('templates/header/head', null, ['slider' => [$slider]]);
get_template_part('templates/page-title');
?>
    <div class="container">
        <div id="main-content">
<?php
get_template_part('templates/category/content');
