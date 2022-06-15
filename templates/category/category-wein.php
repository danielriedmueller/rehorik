<?php
defined( 'ABSPATH' ) || exit;

get_template_part('templates/header/head');
get_template_part('templates/header/slider', null, ['items' => [
    [
        'claim' => 'Feine Weine seit 1928',
        'img'=> 'startseite-header-wein',
        'buttons' => [
            '/produkt/la-goutte-rose/' => 'Schon probiert?<br>Fruchtiger Rosé aus Südfrankreich'
        ]
    ]
]]);
get_template_part('templates/page-title');
?>
    <a id="rehorik-logo" href="<?php echo get_home_url(); ?>"></a>
    <div class="rehorik-page-introduction-outer">
        <div class="container">
            <div class="rehorik-page-introduction">
                Grandiose Weine gehören zu Rehorik, genauso wie frisch gerösteter Kaffee.
                Bei der Suche nach neuen Weinen achtet unser Team nicht nur auf optimalen Geschmack und Harmonie im Glas. Ein großes Augenmerk bei der Auswahl der Weine liegt in ihrer Herkunft. Ein gutes familiäres Verhältnis zu den Weingütern ist genauso entscheidend wie die Arbeit im Weinberg, die im Einklang mit der Natur stattfinden muss. Davon überzeugen sich unsere Sommeliers vor Ort in den Anbaugebieten. Sie entdecken die neusten Trends, beliebte Klassiker und geheime Spezialitäten.
                Eine kleine Auswahl unseres Sortiments, das über 500 verschiedene Weine umfasst, stellen wir in unserem Onlineshop vor.
            </div>
        </div>
    </div>
    <div class="container">
        <div id="main-content">
<?php
get_template_part('templates/category/content');