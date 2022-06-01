<?php
defined( 'ABSPATH' ) || exit;

get_template_part('templates/header/head');
get_template_part('templates/header/slider', null, ['items' => [
    [
        'claim' => 'Viel Erfahrung mit Wein und wir kennen uns mega aus',
        'img'=> 'startseite-header-wein',
        'buttons' => [
            'mailto:<?= BARISTASTORE_EMAIL ?>?subject=Beratungstermin%20Maschinen%20und%20Equipment' => 'Schon probiert? #Link zu einem tollen Wein#'
        ]
    ]
]]);
get_template_part('templates/page-title');
?>
    <a id="rehorik-logo" href="<?php echo get_home_url(); ?>"></a>
    <div class="rehorik-page-introduction-outer">
        <div class="container">
            <div class="rehorik-page-introduction">
                Naturwein gibts auch nur bei uns... Hier wird Naturwein erklärt. orem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis
            </div>
        </div>
    </div>
    <div class="container">
        <div id="main-content">
<?php
get_template_part('templates/category/content');