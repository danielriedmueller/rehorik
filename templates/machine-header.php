<?php
get_template_part('templates/header/slider', null, ['items' => [
    [
        'claim' => 'Werdet zum Home Barista und holt Euch Eure Lieblingsmaschine!',
        'img'=> 'header-maschinen',
        'buttons' => [
            'mailto:<?= BARISTASTORE_EMAIL ?>?subject=Beratungstermin%20Maschinen%20und%20Equipment' => 'Beratungstermin vereinbaren'
        ]
    ]
]]);
?>
<a id="rehorik-logo" href="<?php echo get_home_url(); ?>"></a>
