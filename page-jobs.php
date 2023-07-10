<?php
require_once(get_stylesheet_directory() . '/helper/page_helper.php');

$blocks = parse_blocks(get_the_content());
$jobs = [];
foreach ($blocks as $block) {
    if ($block['blockName'] === 'core/group') {
        $jobs[] = merge_inner_blocks([$block]);
    }
}

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
    <?php foreach ($jobs as $job): ?>
        <div class="job-description-outer">
            <div class="container">
                <div class="job-description">
                    <span class="center">Zur Unterstützung unseres Teams, insbesondere in der Produktion, suchen wir ab sofort</span>
                    <?= $job ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="container">
        <div class="apply-now">
            <h2>Dein Job ist nicht dabei?</h2>
            <p>und du möchtest Teil unseres Teams werden? Schick uns einfach eine Mail und wir kontaktieren dich.</p>
            <a class="button" href="mailto:<?= JOBS_MAIL ?>">Jetzt bewerben</a>
        </div>
    </div>
</div>
<?php get_footer(); ?>

