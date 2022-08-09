<?php
get_template_part('templates/header/head', null, [
    'slider' => [
        [
            'claim' => 'Vom Ursprung inspiriert',
            'img' => 'header-tradition',
            'buttons' => [
                '/produkt/karlsbader-mischung' => 'Unsere Karslbader Mischung',
            ],
        ],
        [
            'claim' => 'Bis heute weitergelebt',
            'img' => 'startseite-header-roesterei',
            'buttons' => [
                '/produkt/hochlandmischung' => 'Regensburger Mischung',
            ],
        ],
    ],
]);
get_template_part('templates/introduction', null, [
    'text' => 'Seit vier Generationen lebt Rehorik Kaffee, Wein und Feinkost. Damit hat Hugo Rehorik vor über 90 Jahren
                begonnen. Und wir
                tun es immer noch. Deshalb wissen wir genau, wie es geht und worauf wir achten müssen: Wo kommen die
                Produkte her? Wie
                werden sie produziert? Und besonders wichtig: Überzeugt uns die Qualität? Das überprüfen wir regelmäßig.
                Wir
                besuchen Kaffeebauern und Produzenten weltweit. Wir schauen uns um, probieren aus und bringen mit, was
                uns gefällt – seit
                1928 als familiengeführtes Unternehmen.',
]);
get_template_part('templates/page-title');
?>
<div class="container">
    <div id="timeline-outer">
        <div id="timeline">
            <div>
                <section class="year">
                    <h3>1928</h3>
                    <section>
                        <ul>
                            <li><span>Firmengründung einer Kaffeerösterei mit Ladengeschäft von Hugo Rehorik in Karlsbad (CZ)</span>
                            </li>
                            <li><img alt="Tradition 1928"
                                     src="<?= get_stylesheet_directory_uri() . '/assets/img/pages/tradition/tradition-bildmaterial-800x500px-1928.jpg' ?>">
                            </li>
                        </ul>
                    </section>
                </section>
                <section class="year">
                    <h3>1945</h3>
                    <section>
                        <ul>
                            <li><span>Familie Rehorik wird vertrieben und lässt sich in Regensburg nieder</span></li>
                        </ul>
                    </section>
                </section>
                <section class="year">
                    <h3>1948</h3>
                    <section>
                        <ul>
                            <li><span>Hugo gründet die Firma ‚Hugo Rehorik & Co.‘</span></li>
                        </ul>
                    </section>
                </section>
                <section class="year">
                    <h3>1950</h3>
                    <section>
                        <ul>
                            <li><span>2. Generation Heinz Rehorik Heinz kommt nach seiner Musikerkarriere in elterlichen Betrieb</span>
                            </li>
                            <li><img alt="Tradition"
                                     src="<?= get_stylesheet_directory_uri() . '/assets/img/pages/tradition/tradition-bildmaterial-800x500px-1950.jpg' ?>">
                            </li>
                        </ul>
                    </section>
                </section>
                <section class="year">
                    <h3>1952</h3>
                    <section>
                        <ul>
                            <li><img class="narrow" alt="Tradition"
                                     src="<?= get_stylesheet_directory_uri() . '/assets/img/pages/tradition/tradition-bildmaterial-500px-1952.jpg' ?>">
                            </li>
                        </ul>
                    </section>
                </section>
                <section class="year">
                    <h3>1953</h3>
                    <section>
                        <ul>
                            <li><img alt="Tradition"
                                     src="<?= get_stylesheet_directory_uri() . '/assets/img/pages/tradition/tradition-bildmaterial-800x500px-1953.jpg' ?>">
                            </li>
                        </ul>
                    </section>
                </section>
                <section class="year">
                    <h3>1960</h3>
                    <section>
                        <ul>
                            <li><span>Heinz eröffnet die Weinabteilung</span></li>
                            <li><img alt="Tradition"
                                     src="<?= get_stylesheet_directory_uri() . '/assets/img/pages/tradition/tradition-bildmaterial-800x500px-1960.jpg' ?>">
                            </li>
                        </ul>
                    </section>
                </section>
                <section class="year">
                    <h3>1969</h3>
                    <section>
                        <ul>
                            <li><span>Der Brixener Hof wird saniert, die Rösterei wird dort eingebaut</span></li>
                            <li><img alt="Tradition"
                                     src="<?= get_stylesheet_directory_uri() . '/assets/img/pages/tradition/tradition-bildmaterial-800x500px-1969.jpg' ?>">
                            </li>
                        </ul>
                    </section>
                </section>
                <section class="year">
                    <h3>1972</h3>
                    <section>
                        <ul>
                            <li><span>Heinz eröffnet die Filiale im Donaueinkaufszentrum (DEZ)</span></li>
                        </ul>
                    </section>
                </section>
                <section class="year">
                    <h3>1981</h3>
                    <section>
                        <ul>
                            <li><span>3. Generation Joachim Rehorik</span></li>
                            <li><img class="narrow" alt="Tradition"
                                     src="<?= get_stylesheet_directory_uri() . '/assets/img/pages/tradition/tradition-bildmaterial-500x800px-1981.jpg' ?>">
                            </li>
                        </ul>
                    </section>
                </section>
                <section class="year">
                    <h3>1986</h3>
                    <section>
                        <ul>
                            <li><span>Joachim eröffnet einen neuen, größeren Laden im DEZ mit Käsetheke</span></li>
                            <li><img alt="Tradition"
                                     src="<?= get_stylesheet_directory_uri() . '/assets/img/pages/tradition/tradition-bildmaterial-800x500px-1986.jpg' ?>">
                            </li>
                        </ul>
                    </section>
                </section>
                <section class="year">
                    <h3>1990</h3>
                    <section>
                        <ul>
                            <li><span>Joachim eröffnet am Brixener Hof die Käseabteilung</span></li>
                            <li><img class="narrow" alt="Tradition"
                                     src="<?= get_stylesheet_directory_uri() . '/assets/img/pages/tradition/tradition-bildmaterial-500x800px-1990.jpg' ?>">
                            </li>
                        </ul>
                    </section>
                </section>
                <section class="year">
                    <h3>2000</h3>
                    <section>
                        <ul>
                            <li><span>Joachim übernimmt einen Weinladen in der Gesandtenstraße</span></li>
                        </ul>
                    </section>
                </section>
                <section class="year">
                    <h3>2001</h3>
                    <section>
                        <ul>
                            <li><span>Direkter Einkauf aus Guatemala</span></li>
                            <li><img alt="Tradition"
                                     src="<?= get_stylesheet_directory_uri() . '/assets/img/pages/tradition/tradition-bildmaterial-800x500px-2001.jpg' ?>">
                            </li>
                        </ul>
                    </section>
                </section>
                <section class="year">
                    <h3>2011</h3>
                    <section>
                        <ul>
                            <li><span>4. Generation Heiko Rehorik</span></li>
                            <li><img alt="Tradition"
                                     src="<?= get_stylesheet_directory_uri() . '/assets/img/pages/tradition/tradition-bildmaterial-800x500px-2011.jpg' ?>">
                            </li>
                        </ul>
                    </section>
                </section>
                <section class="year">
                    <h3>2013</h3>
                    <section>
                        <ul>
                            <li><span>Einkauf aus Honduras</span></li>
                            <li><img alt="Tradition"
                                     src="<?= get_stylesheet_directory_uri() . '/assets/img/pages/tradition/tradition-bildmaterial-800x500px-2013.jpg' ?>">
                            </li>
                        </ul>
                    </section>
                </section>
                <section class="year">
                    <h3>2014</h3>
                    <section>
                        <ul>
                            <li><span>Heiko gründet das Café 190° Am Brixener Hof 6</span></li>
                            <li><img alt="Tradition"
                                     src="<?= get_stylesheet_directory_uri() . '/assets/img/pages/tradition/tradition-bildmaterial-800x500px-2014.jpg' ?>">
                            </li>
                        </ul>
                    </section>
                </section>
                <section class="year">
                    <h3>2021</h3>
                    <section>
                        <ul>
                            <li><span>Gründung des neuen Delicatessen Laden Am Brixener Hof 11</span></li>
                            <li><img alt="Tradition"
                                     src="<?= get_stylesheet_directory_uri() . '/assets/img/pages/tradition/tradition-bildmaterial-800x500px-2021.jpg' ?>">
                            </li>
                        </ul>
                    </section>
                </section>
                <section class="year">
                    <h3>2021</h3>
                    <section>
                        <ul>
                            <li><span>Neuer Standort: Rösterei & Kaffeehaus in der Straubinger Straße 62 A</span></li>
                            <li><img alt="Tradition 2021"
                                     src="<?= get_stylesheet_directory_uri() . '/assets/img/pages/tradition/tradition-bildmaterial-800x500px-2021-2.jpg' ?>">
                            </li>
                        </ul>
                    </section>
                </section>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
