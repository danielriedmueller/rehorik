<?php
defined('ABSPATH') || exit;

get_template_part('templates/header/head', null, [
    'slider' => [
        [
            'img' => 'startseite-header-spirits'
        ],
    ],
]);
get_template_part('templates/introduction', null, [
    'text' => 'Tradition, Handwerk und das Wissen, wo das Material herkommt steht nicht nur bei unserem Kaffee an erster Stelle. Feinste Spirituosen benötigen viel Sorgfalt und Aufmerksamkeit, um aus dem jeweiligen Produkt mit viel Können und Erfahrung das beste herauszuholen. Wir vom Team Rehorik legen zum einen großen Wert auf regionale Brennereien und persönlichen Kontakt, denn eine gute Beziehung zu unseren Herstellern ist uns ebenso wichtig wie die Qualität des Produktes selbst. Andererseits treibt uns auch die Suche nach dem Besonderen aus aller Welt an und so finden sich in unserem Spirituosensortiment auch weit entfernt hergestellte Schätze aus den verschiedensten Ecken dieser Welt.',
]);
get_template_part('templates/page-title');
?>
    <div class="container">
        <div id="main-content">
<?php
get_template_part('templates/category/content');
