<?php
get_template_part('templates/header/head', null, [
    'slider' => [
        [
            'claim' => 'Jobs & Karriere',
            'img' => 'header-weltfrauentag',
            'buttons' => [],
        ],
    ],
]);
?>
<div id="jobs">
    <div class="container">
        <div class="intro">Wir als Firma Rehorik wollen mit bestem Kaffee, gutem Wein und hochwertigen Delikatessen
            Menschen begeistern. Wir probieren viel, entdecken neu und geben unser Wissen in Seminaren und Tastings
            weiter. Über die Jahre ist eine Marke entstanden, die eine Brücke zwischen Tradition und Startup schlägt.
            Wir lieben diesen Mix aus Erfahrungen, Teamwork, Leidenschaft für jedes Produkt, den gemeinsamen Espresso
            beim morgendlichen Meeting und der ein oder anderen kleinen Party!
        </div>
    </div>
    <div class="container">
        <div class="apply-now">
            <h2>Du möchtest Teil unseres Teams werden?</h2>
            <p>Schick uns einfach eine Mail und wir kontaktieren dich.</p>
            <a class="button" href="mailto:<?= JOBS_MAIL ?>">Jetzt bewerben</a>
        </div>
    </div>
</div>
<?php get_footer(); ?>

