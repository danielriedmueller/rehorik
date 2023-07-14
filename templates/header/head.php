<?php
require_once(get_stylesheet_directory() . '/helper/page_helper.php');


$slider = [
    'large' => get_post_meta(get_the_ID(), Reh_Page_Header::META_IMAGE_LARGE, true),
];
$hasSlider = !empty($slider['large']) || !empty($slider['medium']) || !empty($slider['small']);
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <title><?= createPageTitle() ?></title>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="manifest" href="<?= get_stylesheet_directory_uri() . '/assets/manifest.json' ?>">
    <meta name="theme-color" content="#5C0D2F"/>
    <link rel="icon" href="<?= get_stylesheet_directory_uri() . '/assets/img/logos/favicon.ico' ?>"
          type="image/x-icon"/>
    <link rel="apple-touch-icon" href="<?= get_stylesheet_directory_uri() . '/assets/img/logos/apple-touch-icon.png' ?>">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#C6B47F">
    <meta name="apple-mobile-web-app-title" content="Rehorik">
    <meta name="description"
          content="Kaffee aus eigener Traditions-Rösterei seit vier Generationen vom Hause Rehorik. Wir führen auch eine hervorragend sortierte Wein- und Spirituosenauswahl."/>
    <meta name='robots' content='index, follow, archive'/>
    <meta property="og:locale" content="de_DE"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="Kaffee, Wein &amp; Feinkost aus Regensburg - Rehorik"/>
    <meta property="og:description"
          content="Kaffee aus eigener Traditions-Rösterei seit vier Generationen vom Hause Rehorik. Wir führen auch eine hervorragend sortierte Wein- und Spirituosenauswahl."/>
    <meta property="og:url" content="https://www.rehorik.de/"/>
    <meta property="og:site_name" content="Rehorik"/>
    <?php wp_head(); ?>
</head>
<body <?php body_class('rehorik' . ($hasSlider ? ' has-slider' : '')); ?>>
<div id="page-container">
    <?php
    get_template_part('templates/header/menu');

    if ($hasSlider) get_template_part('templates/header/header-image', null, ['items' => $slider]);
    get_template_part('templates/introduction', null, [
        'text' => '<span>Hier findest Du die perfekten Geschenke für befreundete Feinschmecker:innen oder Schmankerl für verwandte Genießer:innen. Wir haben das Beste aus unseren Wein- und Delikatessenregalen geholt und schon mal ein paar Geschenke zusammengestellt.
</span><span>Mit unserem bruchsicheren Versand überleben Rehorik Weihnachtsgeschenke auch die wildeste Schlittenfahrt, direkt zu Deiner Familie, Deinen Kolleg:innen oder Freund:innen nach Hause. Das Weihnachtswichtel-Team wünscht viel Spaß beim Verschenken!</span>',
    ]);
    ?>
