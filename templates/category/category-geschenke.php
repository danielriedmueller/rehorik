<?php
defined('ABSPATH') || exit;

get_template_part('templates/header/head', null, [
    'slider' => [
        [
            'claim' => 'Einfach für jeden Anlass',
            'img' => 'header-geschenkkoerbe',
            'buttons' => [
                '/produkt/heiliger-bimbam' => 'Etwas für unterm Baum gesucht?<br>Heiliger Bimbam',
            ],
        ],
    ],
]);
get_template_part('templates/introduction', null, [
    'text' => '<span>Hier findet Ihr die perfekten Geschenke für befreundete Feinschmecker:innen oder Schmankerl für verwandte Genießer:innen. Wir haben das Beste aus unseren Wein- und Delikatessenregalen geholt und schon mal ein paar Geschenk zusammengestellt.
</span><span>Mit unserem bruchsicheren Versand überleben Rehorik Weihnachtsgeschenke auch die wildeste Schlittenfahrt, direkt zu Eurer Familie, Euren Kolleg:innen oder Freund:innen nach Hause. Der Verpackungsaufwand ist höher, deswegen müssen wir hier leider 2 € aufschlagen. Das Weihnachtswichtel-Team dankt!</span>',
]);
get_template_part('templates/page-title');
?>
    <div class="container">
        <div id="main-content">
<?php
get_template_part('templates/category/content');
?>
