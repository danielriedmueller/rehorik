<?php
get_template_part('templates/header/head', null, [
    'slider' => [
        [
            'claim' => 'Wir helfen dir weiter',
            'img' => 'header-standorte',
            'buttons' => [
                    '/standorte' => 'Unsere Standorte'
            ],
        ],
    ],
]);
?>
<div class="rehorik-page-introduction-outer">
    <div class="container">
        <div class="rehorik-page-introduction">
            Bei Rehorik arbeiten viele Menschen. Alle kompetent und shit. Wir helfen dir bei einfach allem. Wir kennen uns so gut mit Kaffee und Genuss aus, es ist der Wahnsinn!
        </div>
    </div>
</div>
<div class="container">
    <?php
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            the_content();
        }
    }
    ?>
</div>
<?php get_footer(); ?>
