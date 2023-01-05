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
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.
                Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis,
                ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo,
                fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis
                vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus
                elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu,</p>
        </div>
    </div>
    <div>
        <div>
            <h2>Wir suchen ab sofort</h2>
            <?php
            if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post();
                    the_content();
                }
            }
            ?>
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

