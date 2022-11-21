<?php
defined( 'ABSPATH' ) || exit;

$slider = [
    'claim' => 'Werdet zum Home Barista und holt Euch Eure Lieblingsmaschine!',
    'img' => 'header-maschinen',
    'buttons' => [
        'https://app.resmio.com/rehorik-maschinenberatung/widget?backgroundColor=%235c0d2f&color=%23ceb67f&commentsDisabled=true&facebookLogin=false&&linkBackgroundColor=%23ceb67f&newsletterSignup=false' => 'Beratungstermin vereinbaren'
    ]
];
get_template_part('templates/header/head', null, ['slider' => [$slider]]);
get_template_part('templates/page-title');
?>
    <div class="container">
        <div id="main-content">
<?php
get_template_part('templates/category/content');
