<?php
get_template_part('templates/header/head', null, [
    'slider' => [
        [
            'claim' => 'Überall unterwegs',
            'img' => 'header-standorte',
            'buttons' => [
                get_term_link(TICKET_CATEGORY_SLUG, 'product_cat') => 'Alle Events in unseren Standorten',
            ],
        ],
    ],
]);
?>
<div class="page-title-outer">
    <div class='page-title'><h1><?= the_title() ?></h1></div>
</div>
<div class="rehorik-page-introduction-outer">
    <div class="container max-width-small">
        <div class="rehorik-page-introduction locations">
            <div class="table-outer">
                <table id="locations-table">
                    <tbody>
                    <tr>
                        <td><a href="#kaffeehaus">Rösterei & Kaffeehaus</a></td>
                        <td>0941 / 788 353 20</td>
                        <td>
                            <table>
                                <tbody>
                                <tr>
                                    <td>MO. - FR.</td>
                                    <td>08:00 - 18:00</td>
                                </tr>
                                <tr>
                                    <td>SA.</td>
                                    <td>09:00 - 18:00</td>
                                </tr>
                                <tr>
                                    <td>Karfreitag, Ostermontag</td>
                                    <td>geschlossen</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td><a target="_blank" href="<?= MENU_STRAUBINGER ?>">Speisekarte</a></td>
                        <td>
                            <a target="_blank"
                               href="https://app.resmio.com/rehorik-rosterei-kaffehaus/widget?backgroundColor=%235c0d2f&color=%23C6B47F&commentsDisabled=true&facebookLogin=false&&linkBackgroundColor=%23C6B47F&newsletterSignup=false">Reservieren</a>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="#cafe190">Café 190°</a></td>
                        <td>0941 / 59 57 92 27</td>
                        <td>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>MO. - SO.</td>
                                        <td>09:00 - 18:00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td><a target="_blank" href="<?= MENU_190?>">Speisekarte</a></td>
                        <td>
                            <a target="_blank"
                               href="https://app.resmio.com/cafe-190-grad/widget?backgroundColor=%235c0d2f&color=%23C6B47F&commentsDisabled=true&facebookLogin=false&&linkBackgroundColor=%23C6B47F&newsletterSignup=false">Reservieren</a>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="#kaffeeladen">Kaffeeladen & Weinkeller</a></td>
                        <td>0941 / 58 65 276</td>
                        <td>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>MO. - MI.</td>
                                        <td>10:00 - 18:00</td>
                                    </tr>
                                    <tr>
                                        <td>DO. - FR.</td>
                                        <td>10:00 - 18:30</td>
                                    </tr>
                                    <tr>
                                        <td>SA.</td>
                                        <td>09:00 - 18:00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="#deliladen">Deliladen</a></td>
                        <td>0941 / 788 353 50</td>
                        <td>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>MO. - MI.</td>
                                        <td>09:00 - 13:00</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>14:00 - 18:00</td>
                                    </tr>
                                    <tr>
                                        <td>DO. - FR.</td>
                                        <td>09:00 - 18:30</td>
                                    </tr>
                                    <tr>
                                        <td>SA.</td>
                                        <td>09:00 - 16:00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="#dez">DEZ</a></td>
                        <td>0941 / 297 99 996</td>
                        <td>
                            <table>
                                <tbody>
                                <tr>
                                    <td>MO. - SA.</td>
                                    <td>09:30 - 20:00</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="#gesandtenstrasse">Gesandtenstraße</a></td>
                        <td>0941 / 59 99 848</td>
                        <td>
                            <table>
                                <tbody>
                                <tr>
                                    <td>MO - FR.</td>
                                    <td>10:00 - 19:00</td>
                                </tr>
                                <tr>
                                    <td>SA.</td>
                                    <td>10:00 - 18:00</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>Verwaltung</td>
                        <td><?= CONTACT_PHONE ?></td>
                        <td>
                            <table>
                                <tbody>
                                <tr>
                                    <td>MO - FR.</td>
                                    <td>08:00 - 15:00</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="locations-map"></div>
<div id="locations-description">
    <div id="stammhaus">
        <div>
            <div class="location-text">
                <h4>Unser Stammhaus</h4>
                <h5 class="mb-s">mit Rösterei, Kaffeeladen, Weinkeller & Café 190°</h5>
                <p class="mb-s">Unser Stammhaus findest Du am östlichen
                    Rand der Regensburger Altstadt. Die ehemalige
                    Residenz der Bischöfe von Brixen ist über 1.000
                    Jahre alt.</p>
                <div><b>ADRESSE</b></div>
                <div class="mb-s">Am Brixener Hof 6 / 93047 Regensburg</div>
                <h5 class="mb-s" id="kaffeeroesterei">Kaffeerösterei</h5>
                <p>Unser Kugelröster ist über 90 Jahre alt. Und
                    mittlerweile werden darin 50 verschiedene Kaffeesorten veredelt. Wer am Kugelröster steht,
                    muss die Bohnen verstehen und das richtige
                    Feeling für den Kaffee haben – das ist Arbeit
                    mit allen Sinnen.</p>
            </div>
            <div class="location-img">
                <img alt="Stammhaus"
                     src="<?= get_stylesheet_directory_uri() . '/assets/img/standorte/stammhaus-1000x900px.webp' ?>">
            </div>
        </div>
    </div>
    <div id="cafe190">
        <div>
            <div class="location-text">
                <h5 class="mb-s">Café 190°</h5>
                <p class="mb-s">Für einen Besuch im Café 190° sprechen viele Gründe: Du bekommst
                    guten Kaffee und leckeres Frühstück mit Käse und Wurst aus unserem
                    Deliladen. Und durch eine Glaswand im Café kannst Du uns beim Rösten
                    zuschauen.</p>
                <div><b>ÖFFNUNGSZEITEN</b></div>
                <table class="mb-s">
                    <tbody>
                    <tr>
                        <td>MO. - SO.</td>
                        <td>09:00 - 18:00</td>
                    </tr>
                    </tbody>
                </table>
                <p>warme Küche täglich bis 16 Uhr</p>
                <div>Telefon 0941 / 59 57 92 27</div>
            </div>
            <div class="location-img">
                <img alt="Cafe 190"
                     src="<?= get_stylesheet_directory_uri() . '/assets/img/standorte/190-1000x746px.webp' ?>">
            </div>
        </div>
    </div>
    <div id="kaffeeladen">
        <div>
            <div class="location-text">
                <h5 class="mb-s">Kaffeeladen</h5>
                <p class="mb-s">In der ehemaligen Kapelle des Bischofssitzes verkaufen wir seit über 60
                    Jahren unseren Kaffee. Und nicht nur das: Tee, Pralinen und andere Süßwaren warten auf
                    Dich.</p>
                <div><b>ÖFFNUNGSZEITEN</b></div>
                <table class="mb-s">
                    <tbody>
                    <tr>
                        <td>MO. - MI.</td>
                        <td>10:00 - 18:00</td>
                    </tr>
                    <tr>
                        <td>DO. - FR.</td>
                        <td>10:00 - 18:30</td>
                    </tr>
                    <tr>
                        <td>SA.</td>
                        <td>09:00 - 18:00</td>
                    </tr>
                    <tr>
                        <td>SO.</td>
                        <td>Geschlossen</td>
                    </tr>
                    </tbody>
                </table>
                <div>Telefon 0941 / 58 65 276</div>
            </div>
            <div class="location-img">
                <img alt="Kaffeeladen"
                     src="<?= get_stylesheet_directory_uri() . '/assets/img/standorte/kaffeeladen-1000x642px.webp' ?>">
            </div>
        </div>
    </div>
    <div id="weinkeller">
        <div>
            <div class="location-text">
                <h5 class="mb-s">Weinkeller</h5>
                <p class="mb-s">Unseren Wein gibt‘s gleich nebenan - im Gewölbekeller. Dort wurde früher schon
                    der
                    Wein gelagert. In unserem Sortiment sind über 400 Sorten.
                    Außerdem findest Du dort Spirits und alles was dazugehört.</p>
                <div><b>ÖFFNUNGSZEITEN</b></div>
                <table class="mb-s">
                    <tbody>
                    <tr>
                        <td>MO. - MI.</td>
                        <td>10:00 - 18:00</td>
                    </tr>
                    <tr>
                        <td>DO. - FR.</td>
                        <td>10:00 - 18:30</td>
                    </tr>
                    <tr>
                        <td>SA.</td>
                        <td>09:00 - 18:00</td>
                    </tr>
                    <tr>
                        <td>SO.</td>
                        <td>Geschlossen</td>
                    </tr>
                    </tbody>
                </table>
                <div class="mb-s">Telefon 0941 / 58 65 276</div>
            </div>
            <div class="location-img">
                <img alt="Weinkeller"
                     src="<?= get_stylesheet_directory_uri() . '/assets/img/standorte/weinkeller-1000x642px.webp' ?>">
            </div>
        </div>
    </div>
    <div id="deliladen">
        <div>
            <div class="location-text">
                <h4>Unser Deliladen</h4>
                <h5 class="mb-s">Käse & Feinkost</h5>
                <p class="mb-s">Gegenüber vom Stammhaus am Brixener Hof ist
                    unser Delicatessen-Laden. In der Frischetheke
                    haben wir Platz für 130 verschiedene Sorten
                    Käse. Obendrauf gibt‘s hier Wurst, Öle, Gewürze,
                    Soßen und vieles mehr - alles, was das kulinarische Herz begehrt.</p>
                <div><b>ÖFFNUNGSZEITEN</b></div>
                <table class="mb-s">
                    <tbody>
                    <tr>
                        <td>MO. - MI.</td>
                        <td>09:00 - 13:00 Uhr</td>
                        <td>14:00 - 18:00 Uhr</td>
                    </tr>
                    <tr>
                        <td>DO. - FR.</td>
                        <td>09:00 - 18:30 Uhr</td>
                    </tr>
                    <tr>
                        <td>SA.</td>
                        <td>09:00 - 16:00 Uhr</td>
                    </tr>
                    <tr>
                        <td>SO.</td>
                        <td>Geschlossen</td>
                    </tr>
                    </tbody>
                </table>
                <div><b>ADRESSE</b></div>
                <div>Am Brixener Hof 11 / 93047 Regensburg</div>
                <div>Telefon 0941 / 788 353 50</div>
            </div>
            <div class="location-img">
                <img alt="Deliladen"
                     src="<?= get_stylesheet_directory_uri() . '/assets/img/standorte/deli-1000x900px.webp' ?>">
            </div>
        </div>
    </div>
    <div id="dez">
        <div>
            <div class="location-text">
                <h4 class="mb-s">Rehorik im Dez</h4>
                <p class="mb-s">Unser Geschäft im Donau-Einkaufszentrum versorgt auch die Regensburger:innen im
                    Nordosten der Stadt mit unseren Spezialitäten. Am
                    Ausschank kannst Du dir frisch gebrühten Kaffee und Espresso holen und natürlich unsere
                    Kaffeebohnen kaufen. Außerdem gibt‘s auch im
                    DEZ unsere Weine, Spirituosen und Feinkost.
                    Wenn Du ein Geschenk brauchst, stellen wir das
                    gerne für Dich zusammen.</p>
                <div><b>ÖFFNUNGSZEITEN</b></div>
                <table class="mb-s">
                    <tbody>
                    <tr>
                        <td>MO. - SA.</td>
                        <td>09:30 - 20:00 Uhr</td>
                    </tr>
                    <tr>
                        <td>SO.</td>
                        <td>Geschlossen</td>
                    </tr>
                    </tbody>
                </table>
                <div><b>ADRESSE</b></div>
                <div>Weichser Weg 5 / 93059 Regensburg</div>
                <div>Telefon 0941 / 297 99 996</div>
            </div>
            <div class="location-img">
                <img alt="DEZ" src="<?= get_stylesheet_directory_uri() . '/assets/img/standorte/dez-1000x766px.webp' ?>">
            </div>
        </div>
    </div>
    <div id="gesandtenstrasse">
        <div>
            <div class="location-text">
                <h4 class="mb-s">Rehorik in der Gesandtenstraße</h4>
                <p class="mb-s">In vino veritas - wer herausfinden will, ob das stimmt, besucht uns am besten in der
                    Gesandtenstraße.
                    Hier sind die Regale voll - von Weinen aus Europa und Übersee bis zu Sekt und Spirituosen.
                    Natürlich gibt es auch unseren Kaffee
                    in gewohnter Qualität und Frische. Den Espresso des Monats kannst du Dir übrigens direkt
                    zubereiten lassen.</p>
                <div><b>ÖFFNUNGSZEITEN</b></div>
                <table class="mb-s">
                    <tbody>
                    <tr>
                        <td>MO. - FR.</td>
                        <td>10:00 - 19:00 Uhr</td>
                    </tr>
                    <tr>
                        <td>SA.</td>
                        <td>10:00 - 18:00 Uhr</td>
                    </tr>
                    <tr>
                        <td>SO.</td>
                        <td>Geschlossen</td>
                    </tr>
                    </tbody>
                </table>
                <div><b>ADRESSE</b></div>
                <div>Gesandtenstraße 16 / 93047 Regensburg</div>
                <div>Telefon 0941 / 59 99 848</div>
            </div>
            <div class="location-img">
                <img alt="Gesandtenstraße"
                     src="<?= get_stylesheet_directory_uri() . '/assets/img/standorte/gesandtenstrass-1000x809px.webp' ?>">
            </div>
        </div>
    </div>
    <div id="kaffeehaus">
        <div>
            <div class="location-text">
                <h4 class="mb-s">Rösterei & Kaffeehaus</h4>
                <p class="mb-s">Kaffee schlürfen, eine Bowl zu Mittag und dabei beim Rösten zuschauen? Das geht
                    alles in
                    unserer neuen Rösterei. Im Verkaufsbereich
                    findest Du ausgewählte Weine, Spirits und Delikatessen. Und falls Du auf der Suche nach der
                    perfekten Espressomaschine oder dem richtigen Kaffeezubehör bist – einfach einen persönlichen
                    Beratungstermin vereinbaren und vorbeikommen.</p>
                <div><b>ÖFFNUNGSZEITEN</b></div>
                <table class="mb-s">
                    <tbody>
                    <tr>
                        <td>MO. - FR.</td>
                        <td>08:00 - 18:00 Uhr</td>
                    </tr>
                    <tr>
                        <td>SA.</td>
                        <td>09:00 - 18:00 Uhr</td>
                    </tr>
                    <tr>
                        <td>SO.</td>
                        <td>Geschlossen</td>
                    </tr>
                    </tbody>
                </table>
                <p>warme Küche täglich bis 16 Uhr</p>
                <div><b>ADRESSE</b></div>
                <div>Straubinger Straße 62a / 93055 Regensburg</div>
                <div>Telefon 0941 / 788 353 20</div>
            </div>
            <div class="location-img">
                <img alt="Kaffeehaus"
                     src="<?= get_stylesheet_directory_uri() . '/assets/img/standorte/straubinger-1000x766px.webp' ?>">
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
