<?php
defined( 'ABSPATH' ) || exit;

$slider = [
    'claim' => 'Werde zum Home Barista und hole Dir Deine Lieblingsmaschine!',
    'img' => 'header-maschinen',
    'buttons' => [
        'https://app.resmio.com/rehorik-maschinenberatung/widget?backgroundColor=%235c0d2f&color=%23C6B47F&commentsDisabled=true&facebookLogin=false&&linkBackgroundColor=%23C6B47F&newsletterSignup=false' => 'Beratungstermin vereinbaren'
    ]
];
get_template_part('templates/header/head', null, ['slider' => [$slider]]);
get_template_part('templates/page-title');
?>
    <div class="container">
        <div id="main-content">
<?php
get_template_part('templates/category/content');
