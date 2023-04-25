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
            font-size: 59px;
            line-height: 50px;
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

        a {
            color: #3C3C3B;
            text-decoration: none;
            font-family: 'Cond', serif;
            font-size: 59px;
            line-height: 52px;
        }

        h3, h3 a {
            font-family: 'Cond Bold', serif;
            color: #3C3C3B;
            font-size: 59px;
            line-height: 52px;
            margin: 0;
            padding: 0;
            display: inline;
        }

        h1 {
            font-family: 'Cond Bold', serif;
            color: #C6B480;
            font-size: 436px;
            line-height: 315px;
            margin: 0;
            padding: 0;
            text-transform: uppercase;
        }

        h2 {
            font-family: 'Cond Bold', serif;
            color: #3C3C3B;
            text-transform: uppercase;
            font-size: 70px;
            line-height: 64px;
            margin: 0;
            padding: 0;
        }

        p {
            margin: 0;
            padding: 0;
        }

        hr {
            margin: 100px 0;
            width: 100%;
            border: 4px solid #C6B480;
            border-radius: 0;
        }

        #content {
            padding: 150px 150px 0 634px;
        }

        #headline {
            margin-bottom: 200px;
            height: 391px;
        }

        #logo {
            position: absolute;
            left: 150px;
            top: 150px;
        }

        #hugo {
            position: absolute;
            right: 170px;
            top: 700px;
        }

        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 1000px;
        }

        footer img {
            position: absolute;
            bottom: 0;
            left: 0;
            z-index: -1;
        }

        footer #owner {
            position: absolute;
            bottom: 230px;
            right: 150px;
        }
    </style>
</head>
<body>
<div id="logo"><img src="<?= $assetsDir ?>/img/logos/logo-391px.png" /></div>
<div id="hugo"><img src="<?= $assetsDir ?>/img/hugo/hugo-365px.png" /></div>
<div id="content">
    <div id="headline"><h1>Gutschein</h1></div>
    <div id="code">
        <h2>Gutscheincode: <?= $args['code'] ?></h2>
        <h2>Name: <?= $args['name'] ?></h2>
        <h2>Preis: <?= $args['price'] ?> €</h2>
    </div>
    <hr />
    <div id="legal">
        <h2>Bitte beachten</h2>
        <span>Der Gutschein ist nur im Onlineshop unter</span> <h3><a href="https://www.rehorik.de">www.rehorik.de</a></h3> <span>einlösbar.</span>
        <p>Möchtest du den Gutschein lieber für Kaffee, Wein oder Spirits verwenden? Kein Problem! Der Gutschein ist für alle Produkte im Onlineshop einlösbar. Der Restwert bleibt erhalten.</p>
        <p>
            Der Gutschein ist unbegrenzt gültig und kann beliebig oft unter www.rehorik.de verwendet werden, solange ein Restwert vorhanden ist.
            Über die Höhe des Restwerts, geben wir Dir gerne Auskunft. Schreibe uns dazu eine Mail an <a href="mailto:kaffee@rehorik.de">kaffee@rehorik.de</a>.
            Das Guthaben dieses Gutscheins wird nicht verzinst, versteuert oder bar ausgezahlt.
            Bei Diebstahl, Verlust oder Unbrauchbarkeit leisten wir keinen Ersatz.
            Es gelten unsere allgemeinen Geschäftsbedingungen – diese können unter www.rehorik.de eingesehen werden.
        </p>
    </div>
    <hr style="width: 1250px"/>
    <div id="contact">
        <h2>Kontakt</h2>
        <p>Rehorik Rösterei &amp; Feinkost GmbH</p>
        <p>Am Brixener Hof 6, 93047 Regensburg</p>
        <p>Telefon: <a href="tel:0941/7883530">0941/7883530</a></p>
        <p>E-Mail: <a href="mailto:kaffee@rehorik.de">kaffee@rehorik.de</a></p>
        <p><a href="https://www.rehorik.de">www.rehorik.de</a></p>
    </div>
</div>
<footer>
    <div id="owner">
        <p>Geschäftsführer: Heiko Rehorik</p>
        <p>Handelsregister Regensburg HRB 18004</p>
    </div>
    <img src="<?= $assetsDir ?>/img/footer/footer-pdf-2480px-min.png" />
</footer>
</body>
</html>
