<?php
get_header();
get_template_part('templates/header/slider', null, [
    'items' => [
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
?>
    <a id="rehorik-logo" href="<?php echo get_home_url(); ?>"></a>
    <div class="page-title-outer">
        <div class='page-title'><h1><?=the_title()?></h1></div>
    </div>
    <div class="rehorik-page-introduction-outer">
        <div class="container">
            <div class="rehorik-page-introduction">
                <table id="locations-table">
                    <tbody>
                        <tr>
                            <td>Rösterei & Kaffeehaus</td>
                            <td>0941 / 59 57 92 27</td>
                            <td>So. - Mi. 09:00 - 18:00, Do. - Sa. 09:00-23:00</td>
                            <td><a class="menu-icon" href="#"></a></td>
                            <td><a href="https://app.resmio.com/rehorik-rosterei-kaffehaus/widget?backgroundColor=%235c0d2f&color=%23ceb67f&commentsDisabled=true&facebookLogin=false&&linkBackgroundColor=%23ceb67f&newsletterSignup=false">Reservieren</a></td>
                        </tr>
                        <tr>
                            <td>Café 190°</td>
                            <td>0941 / 59 57 92 27</td>
                            <td>So. - Mi. 09:00 - 18:00, Do. - Sa. 09:00-23:00</td>
                            <td><a class="menu-icon" href="#"></a></td>
                            <td><a href="https://app.resmio.com/cafe-190-grad/widget?backgroundColor=%235c0d2f&color=%23ceb67f&commentsDisabled=true&facebookLogin=false&&linkBackgroundColor=%23ceb67f&newsletterSignup=false">Reservieren</a></td>
                        </tr>
                        <tr>
                            <td>Kaffeeladen</td>
                            <td>0941 / 58 65 276</td>
                            <td>So. - Mi. 09:00 - 18:00, Do. - Sa. 09:00-23:00</td>
                        </tr>
                        <tr>
                            <td>Weinkeller</td>
                            <td>0941 / 58 65 276</td>
                            <td>So. - Mi. 09:00 - 18:00, Do. - Sa. 09:00-23:00</td>
                        </tr>
                        <tr>
                            <td>Deliladen</td>
                            <td>0941 / 788 35 350</td>
                            <td>So. - Mi. 09:00 - 18:00, Do. - Sa. 09:00-23:00</td>
                        </tr>
                        <tr>
                            <td>DEZ</td>
                            <td>0941 / 297 99 996</td>
                            <td>So. - Mi. 09:00 - 18:00, Do. - Sa. 09:00-23:00</td>
                        </tr>
                        <tr>
                            <td>Gesandtenstraße</td>
                            <td>0941 / 59 99 848</td>
                            <td>So. - Mi. 09:00 - 18:00, Do. - Sa. 09:00-23:00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="container">
        <div>
            <div>
                <span>Unser Stammhaus</span>
                <span>mit Rösterei, Kaffeeladen, Weinkeller & Café 190°</span>
                <p></p>
            </div>
        </div>
    </div>
<?php get_footer(); ?>