<?php ?>
<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="manifest" href="<?= get_stylesheet_directory_uri() . '/assets/manifest.json' ?>">
        <meta name="theme-color" content="#5C0D2F"/>
        <link rel="icon" href="<?= get_stylesheet_directory_uri() . '/assets/img/logos/favicon.ico' ?>"
              type="image/x-icon"/>
        <link rel="apple-touch-icon" href="<?= get_stylesheet_directory_uri() . '/assets/img/logos/logo_512px.png' ?>">
        <meta name="theme-color" content="white"/>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="#CEB67F">
        <meta name="apple-mobile-web-app-title" content="Rehorik">
        <?php wp_head(); ?>
    </head>
<body <?php body_class('rehorik'); ?>>
<div id="page-container">
    <?php get_template_part('templates/menu'); ?>
    <?php
        if (isProductCategory(MACHINE_CATEGORY_SLUG)) {
        get_template_part('templates/machine-header');
        }
        if (isProductCategory(TICKET_CATEGORY_SLUG)) {
        $eventCat = getProductCategorySlug();
        if (!empty($eventCat)) {
            get_template_part("templates/veranstaltungen/header-${eventCat}");
        }
        }
    ?>