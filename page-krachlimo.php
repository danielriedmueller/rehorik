<!doctype html>
<html class="krachlimo" <?php language_attributes(); ?>>
<head>
    <title>Krachlimo</title>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="theme-color" content="#eb9800"/>
    <link rel="icon" href="<?= get_stylesheet_directory_uri() . '/assets/img/logos/favicon.ico' ?>"
          type="image/x-icon"/>
    <meta name='robots' content='index, follow, archive'/>
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() . '/assets/css/krachlimo.css' ?>">
    <?php wp_head(); ?>
</head>
<body>
<header>
    <a href="/krachlimo" id="logo"></a>
    <nav>
        <a href="#geschichte">Geschichte</a>
        <a href="#die-limo">die Limo</a>
        <a href="#hol-sie-dir">Hol sie dir</a>
        <a href="#krachen-lassen">Krachen lassen</a>
    </nav>
</header>
<main>
    <?php the_content(); ?>
</main>
<footer>
    <div>
        <a href="/" id="rehorik-logo"></a>
        <a href="https://www.riedenburger.de/" id="riedenburger-logo"></a>
    </div>
    <div>
        <a href="<?= get_page_link(IMPRESSUM_PAGE_ID) ?>">Impressum</a>
        <a href="#kontakt">Kontakt</a>
    </div>
</footer>
</body>
</html>
