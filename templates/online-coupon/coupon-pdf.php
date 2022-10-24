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

        #wrapper {
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <div id="logo"><img src="<?= $assetsDir ?>/img/logos/logo_192px.png" /></div>
    <div>
        <div>Code: <?= $args['code'] ?></div>
        <div>Name: <?= $args['name'] ?></div>
        <div>Preis: <?= $args['price'] ?></div>
    </div>
    <footer>
        <p>
            Den aktuellen Gutscheinwert können Sie in unseren Warenhäusern, über unser Kundenzentrum oder im Internet
            unter www.manufactum.de/wertabfrage abrufen. Bei Diebstahl, Verlust oder Unbrauchbarkeit leisten wir
            keinen Ersatz. Das Guthaben dieses Gutscheins wird nicht verzinst oder bar ausgezahlt.
            Es gelten unsere allgemeinen Geschäftsbedingungen – diese können unter www.manufactum.de eingesehen werden.
            Beachten Sie bitte, dass Ausstellungs- und Einlösewährung identisch sein müssen. Der Gutschein ist unbegrenzt
            gültig und in unseren Warenhäusern sowie über unser Kundenzentrum wiederaufladbar.
        </p>
        <p>Einlösbar bei jeder Bestellung aus unseren Katalogen, in unserem Online-Shop
            oder bei einem Einkauf in unseren Warenhäusern.</p>
        <table border="0" cellpadding="10" cellspacing="0" width="590   " id="template_footer">
            <tr>
                <td valign="top">
                    <table border="0" cellpadding="10" cellspacing="0" width="100%">
                        <tr>
                            <td colspan="2" valign="middle">
                                <img src="https://img.mailinblue.com/3459467/images/rnb/original/604f71b8e203d77dd84bd755.png?t=1615819213902" alt="streifen"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" valign="middle" id="credit">
                                <p>
                                    Rehorik Rösterei &amp; Feinkost GmbH
                                    <br>
                                    Am Brixener Hof 6 &#183; 93047 Regensburg
                                    <br>
                                    <a href="tel:0941/7883530">0941/7883530</a> &#183; <a href="mailto:kaffee@rehorik.de">kaffee@rehorik.de</a> &#183; <a href="https://www.rehorik.de">www.rehorik.de</a>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" valign="middle" id="owner">
                                <p>Geschäftsführer: Heiko Rehorik &#183; Handelsregister Regensburg HRB 3945</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </footer>
</div>
</body>
</html>
