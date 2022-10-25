<?php
require_once(get_stylesheet_directory() . '/helper/page_helper.php');

$hasSlider = !empty($args['slider']);
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <?php if (home_url() === PROD_URL): ?>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-X6H63MW5X4"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-X6H63MW5X4', { 'anonymize_ip': true });
    </script>
    <?php endif; ?>
    <title><?= createPageTitle('Rehorik') ?></title>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="manifest" href="<?= get_stylesheet_directory_uri() . '/assets/manifest.json' ?>">
    <meta name="theme-color" content="#5C0D2F"/>
    <link rel="icon" href="<?= get_stylesheet_directory_uri() . '/assets/img/logos/favicon.ico' ?>"
          type="image/x-icon"/>
    <link rel="apple-touch-icon" href="<?= get_stylesheet_directory_uri() . '/assets/img/logos/logo_512px.png' ?>">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#CEB67F">
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
    <?php if ($hasSlider) {
        get_template_part('templates/header/slider', null, ['items' => $args['slider']]);
    } ?>
    <?php get_template_part('templates/header/menu'); ?>
