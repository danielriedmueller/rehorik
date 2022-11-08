<?php $assetsDir = get_stylesheet_directory_uri() . '/assets/'; ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        html, body {
            font-family: 'Cond', serif;
            color: #3C3C3B;
            font-size: 20px;
            line-height: 1.4em;
            height: 100%;
            margin: 0;
            padding: 0;
            border: 0;
            outline: 0;
            -webkit-text-size-adjust: 100%;
            vertical-align: baseline;
            background: transparent;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        h1 {
            color: #CEB67F;
            font-size: 50px;
            text-transform: uppercase;
        }

        h2 {
            color: #3C3C3B;
            text-transform: uppercase;
            font-size: 35px;
        }

        p {
            margin: 0;
            padding: 0;
        }

        hr {
            margin: 100px 0;
            width: 100%;
            border-bottom: 8px solid #CEB67F;
        }

        #wrapper {
            padding: 150px;
        }

        #header {
            margin-bottom: 185px
        }

        #header #logo {
            width: 390px;
            height: 390px;
            margin-right: 90px;
        }

        #content {
            padding-left: 480px;
        }

        footer {
            width: 100%;
            background-color: #CEB67F;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <div id="header">
        <div id="logo"><img src="<?= $assetsDir ?>/img/logos/logo.svg" /></div>
        <h1>Gutschein</h1>
    </div>
    <div id="content">
        <div id="code">
            <h2>Gutscheincode: <?= $args['code'] ?></h2>
            <h2>Name: <?= $args['name'] ?></h2>
            <h2>Preis: <?= $args['price'] ?></h2>
        </div>
        <hr />
        <div id="legal">
            <h2>Bitte beachten</h2>
            <p>Der Gutschein ist nur im Onlineshop unter <strong><a href="https://www.rehorik.de">www.rehorik.de</a></strong> einlösbar.</p>
            <p>Möchtest du den Gutschein lieber für Kaffee, Wein oder Spirits verwenden? Kein Problem! Der Gutschein ist für alle Produkte im Onlineshop einlösbar. Der Restwert bleibt erhalten.</p>
            <p>
                Der Gutschein ist unbegrenzt gültig und kann beliebig oft unter www.rehorik.de verwendet werden, solange ein Restwert vorhanden ist.
                Das Guthaben dieses Gutscheins wird nicht verzinst, vesteuert oder bar ausgezahlt.
                Bei Diebstahl, Verlust oder Unbrauchbarkeit leisten wir keinen Ersatz.
                Es gelten unsere allgemeinen Geschäftsbedingungen – diese können unter www.rehorik.de eingesehen werden.
            </p>
        </div>
        <hr />
        <div id="contact">
            <h2>Kontakt</h2>
            <p>Rehorik Rösterei &amp; Feinkost GmbH, Am Brixener Hof 6, 93047 Regensburg</p>
            <p>Telefon: <a href="tel:0941/7883530">0941/7883530</a></p>
            <p>E-Mail: <a href="mailto:kaffee@rehorik.de">kaffee@rehorik.de</a></p>
            <p><a href="https://www.rehorik.de">www.rehorik.de</a></p>
        </div>
    </div>
</div>
<footer>
    <div>
        <p>Geschäftsführer: Heiko Rehorik</p>
        <p>Handelsregister Regensburg HRB 3945</p>
    </div>
</footer>
</body>
</html>
