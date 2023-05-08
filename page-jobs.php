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
    <div class="job-description-outer">
        <div class="container">
            <div class="job-description">
                <h5>Zur Unterstützung unseres Teams, insbesondere in der Produktion, suchen wir ab sofort</h5>
                <h2>- Eine/n Produktionshelfer/In-</h2>

                <div>
                    <strong>Deine Aufgaben:</strong>
                    <ul>
                        <li>Vorplanung von Bestellungen</li>
                        <li>Abwicklung der Aufträge</li>
                        <li>Zusammenarbeit mit Rösterei und Lager</li>
                    </ul>
                </div>
                <div>
                    <strong>Das bringst du mit:</strong>
                    <ul>
                        <li>Du hast Humor</li>
                        <li>Du stehst Morgens auf um Kaffee zu trinken, nicht umgekehrt!</li>
                        <li>Du hast einen Sinn für hochwertige Produkte</li>
                        <li>Du bringst Teamfähigkeit, strukturierte und selbstständige Arbeitsweisen und ein hohes Maß
                            an Eigeninitiative
                        </li>
                    </ul>
                </div>
                <div>
                    <strong>Deine Vorteile:</strong>
                    <ul>
                        <li>Flexible Arbeitszeiten</li>
                        <li>Ein dynamisches Team mit viel persönlichen Entfaltungsmöglichkeiten</li>
                        <li>Entspannte und offene Unternehmenskultur</li>
                        <li>Zugang zu einem breitgefächerten Netzwerk aus Kaffee, Wein, Gastronomie und Event Branche
                        </li>
                        <li>Rabatte auf Rehorik Produkte</li>
                        <li>Der beste Kaffee der Welt (Kaffee vor Ort für Mitarbeiter gratis)</li>
                    </ul>
                </div>
                <div>
                    Dein Kopfkino arbeitet und du siehst dich schon mit Espresso Tasse neue Aufträge koordinieren?<br>
                    Dann sende uns eine Email mit kurzem Lebenslauf und deiner Motivation für diese Stelle an: <a
                            href="mailto:<?= JOBS_MAIL ?>"><?= JOBS_MAIL ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="apply-now">
            <h2>Dein Job ist nicht dabei?</h2>
            <p>und du möchtest Teil unseres Teams werden? Schick uns einfach eine Mail und wir kontaktieren dich.</p>
            <a class="button" href="mailto:<?= JOBS_MAIL ?>">Jetzt bewerben</a>
        </div>
    </div>
</div>
<?php get_footer(); ?>

