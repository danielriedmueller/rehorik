<?php get_template_part('templates/rehorik-locations'); ?>
<footer>
    <div>
        <div>
            <h2>Zahlungsarten</h2>
            <p>Vorkasse, Paypal</p>
        </div>
        <div>
            <h2>Versand</h2>
            <p>Wir versenden mit Citymail</p>
            <p><img alt="Logo Citymail" src="<?= get_stylesheet_directory_uri() . '/assets/img/footer/logo-web-citymail.svg' ?>"></p>
            <p>Versandkosten: 5,80 €</p>
            <p>Kostenloser Versand ab: 49 €</p>
            <p><small>* Alle Preise sind inkl. MwSt., zzgl. Versand</small></p>
        </div>
    </div>
    <div>
        <div>
            <h2>Kontakt</h2>
            <p><a href="<?= get_page_link(KARRIERE_PAGE_ID) ?>">Karriere</a></p>
            <p><a href="<?= get_page_link(KONTAKT_PAGE_ID) ?>">Kontaktformular</a></p>
        </div>
        <div>
            <h2>Rechtliches</h2>
            <p><a href="<?= get_page_link(WIDERRUFSBELEHRUNG_PAGE_ID) ?>">Widerrufsbelehrung</a></p>
            <p><a href="<?= get_page_link(DATENSCHUTZ_PAGE_ID) ?>">Datenschutz</a></p>
            <p><a href="<?= get_page_link(IMPRESSUM_PAGE_ID) ?>">Impressum</a></p>
            <p><a href="<?= get_page_link(AGB_PAGE_ID) ?>">AGBs</a></p>
        </div>
    </div>
    <div>
        <div>
            <h2>Anmeldung</h2>
            <p><a href="<?= get_page_link(LOGIN_PAGE_ID) ?>">Kundenlogin</a></p>
            <p><b>Probleme bei der Anmeldung?</b></p>
            <p>Senden Sie uns bitte ein Email an</p>
            <p><a href="mailto:<?= IT_SUPPORT_EMAIL ?>"><?= IT_SUPPORT_EMAIL ?></a></p>
            <p>Vielen Dank!</p>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>