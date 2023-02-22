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
            line-height: 52px;
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
            line-height: 70px;
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

        #attendee-info {
            margin-bottom: 200px;
        }

        #event-info {
            margin-bottom: 200px;
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
    <div id="headline"><h1>Ticket</h1></div>
    <div id="attendee-info">
        <h2>Teilnehmer:in: ______________________________- ?></h2>
        <h2>Ticket Art: <?= $args['ticket_name'] ?></h2>
        <h2>Ticketnummer: <?= $args['ticket_id'] ?> €</h2>
    </div>
    <div id="event-info">
        <h2>Veranstalter:in: <?= $args['organizer'] ?></h2>
        <h2>Datum/Uhrzeit: <?= $args['date'] ?></h2>
        <h2>Ort: <?= $args['location'] ?></h2>
    </div>
    <hr />
    <div>
        <?php Tribe__Tickets_Plus__Main::instance()->qr()->inject_qr($args); ?>
        <p>Sicherheits-Code: <?= $args['security_code'] ?></p>
        <p>Ticket-Käufer:in: <?= $args['holder_name'] ?></p>
        <p>Bitte beachtet, dass die Anmeldung verbindlich ist und nicht verschoben, storniert oder umgetauscht werden kann!</p>
    </div>
    <hr />
    <div id="contact">
        <h2>Kontakt</h2>
        <p>Rehorik Rösterei &amp; Feinkost GmbH, Am Brixener Hof 6, 93047 Regensburg</p>
        <p>E-Mail: <a href="mailto:events@rehorik.de">events@rehorik.de</a></p>
        <p>Telefon: <a href="tel:0941/7883530">0941 / 788 35 30</a></p>
        <p><a href="https://www.rehorik.de">www.rehorik.de</a></p>
    </div>
</div>
<footer>
    <div id="owner">
        <p>Geschäftsführer: Heiko Rehorik</p>
        <p>Handelsregister Regensburg HRB 18004</p>
    </div>
    <img src="<?= $assetsDir ?>/img/footer/footer-pdf-2480px.png" />
</footer>
</body>
</html>
