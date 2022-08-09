<?php
defined('ABSPATH') || exit;

get_template_part('templates/header/head', null, [
    'slider' => [
        [
            'claim' => 'Feine Weine seit 1928',
            'img' => 'startseite-header-wein',
            'buttons' => [
                '/produkt/weissburgunder//' => 'Schon probiert? Weißburgunder aus der Pfalz',
            ],
        ],
    ],
]);
get_template_part('templates/introduction', null, [
    'text' => '„Zurück zur Natur“ repräsentiert gerade den aktuellen Zeitgeist unserer Gesellschaft. Eine Bewegung in der Weinwelt, die Punkt wie Nachhaltigkeit un Umweltbewusstsein aufgreift, ist der Trend des Naturweines. Dieser definiert sich durch genaue Handarbeit im Weinberg und „kontrolliertes Nichtstun“ im Weinkeller. Die Winzer lassen den Wein im Keller seinen eigenen Weg gehen. Sie greifen nicht in Gärung und Reifung ein. Der Wein erhält so die Chance sich selbst zu entfalten. Meistens werden Naturweine von Bio-Weingütern produziert oder von Betrieben, die sich den Richtlinien der Biodynamik verschrieben haben.',
]);
get_template_part('templates/page-title');
?>
    <div class="container">
        <div id="main-content">
<?php
get_template_part('templates/category/content');
