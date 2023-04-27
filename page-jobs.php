<?php
get_template_part('templates/header/head', null, [
    'slider' => [
        [
            'claim' => 'Jobs & Karriere',
            'img' => 'header-neue-roesterei',
            'buttons' => [],
        ],
    ],
]);
?>
<div id="jobs">
    <div>
        <div>
            <h2>Das sind wir</h2>
            <p>Wir als Firma Rehorik wollen mit bestem Kaffee, gutem Wein und hochwertigen Delikatessen Menschen
                begeistern.</p>
            <p>Wir probieren viel, entdecken neu und geben unser Wissen in Seminaren und Tastings weiter.
                Über die Jahre ist eine Marke entstanden, die eine Brücke zwischen Tradition und Startup schlägt.</p>
            <p>Wir lieben diesen Mix aus Erfahrungen, Teamwork, Leidenschaft für jedes Produkt, den gemeinsamen
                Espresso beim morgendlichen Meeting und der ein oder anderen kleinen Party!</p>
            <p></p>
        </div>
    </div>
    <div>
        <div>
            <h2>Zur Unterstützung unseres Teams, insbesondere in der Produktion, suchen wir ab sofort</h2>
            <div class="job-description">
                <h3>- Eine/n Produktionshelfer/In-</h3>
                <strong>Deine Aufgaben:</strong>
                <ul>
                    <li>Vorplanung von Bestellungen</li>
                    <li>Abwicklung der Aufträge</li>
                    <li>Zusammenarbeit mit Rösterei und Lager</li>
                </ul>
                <strong>Das bringst du mit:</strong>
                <ul>
                    <li>Vorplanung von Bestellungen</li>
                    <li>Abwicklung der Aufträge</li>
                    <li>Zusammenarbeit mit Rösterei und Lager</li>
                </ul>
                <strong>Deine Vorteile:</strong>
                <ul>
                    <li>Vorplanung von Bestellungen</li>
                    <li>Abwicklung der Aufträge</li>
                    <li>Zusammenarbeit mit Rösterei und Lager</li>
                </ul>
                <p>
                    Dein Kopfkino arbeitet und du siehst dich schon mit Espresso Tasse neue Aufträge koordinieren ?
                    Dann sende uns eine Email mit kurzem Lebenslauf und deiner Motivation für diese Stelle an: <a href="mailto:<?= JOBS_MAIL ?>"><?= JOBS_MAIL ?></a>
                </p>
            </div>
        </div>
    </div>
    <div>
        <div>
            <h2>Dein Job ist nicht dabei?</h2>
            <p>und du möchtest Teil unseres Teams werden? Schick uns einfach eine Mail und wir kontaktieren dich.</p>
            <div><a class="button" href="mailto:<?= JOBS_MAIL ?>">Jetzt bewerben</a></div>
        </div>
    </div>
</div>
<?php get_footer(); ?>

