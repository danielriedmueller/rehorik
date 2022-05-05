<?php
if (isProductCategory(TICKET_CATEGORY_SLUG)) {
    get_template_part('templates/veranstaltungen/veranstaltungen-footer');
} else {
    get_template_part('templates/best-selling-products');
}
get_template_part('templates/social-media-icons');
get_template_part('templates/newsletter-sign-up');
get_template_part('templates/rehorik-locations');
?>
<footer>
    <div class="container">
        <div>
            <div>
                <div>
                    <h2>Zahlungsarten</h2>
                    <p>Vorkasse, Paypal</p>
                    <p>Lastschrift, Kreditkarte</p>
                </div>
                <div>
                    <h2>Versand</h2>
                    <p>Wir versenden mit DHL</p>
                    <p><img alt="Logo DHL"
                            src="<?= get_stylesheet_directory_uri() . '/assets/img/footer/logo-dhl.svg' ?>"></p>
                    <p>Versandkosten: 5,80 €</p>
                    <p>Kostenloser Versand ab: 49 €</p>
                    <p><small>* Alle Preise sind inkl. MwSt., zzgl. Versand</small></p>
                </div>
            </div>
            <div>
                <div>
                    <h2>Kontakt</h2>
                    <p>Ihr habt noch Fragen?</p>
                    <p>Einfach anrufen, persönlich vorbeikommen oder schreibt uns eine Mail.</p>
                    <p><a href="mailto:<?= CONTACT_MAIL ?>?subject=Kundenanfrage&body=Hallo%20Rehorik-Team,%0D%0A%0D%0A<hier%20steht%20die%20Nachricht>"><?= CONTACT_MAIL ?></a></p>
                    <p>0941 / 788 353 0</p>
                </div>
            </div>
            <div>
                <div>
                    <h2>Rechtliches</h2>
                    <p><a href="<?= get_page_link(WIDERRUFSBELEHRUNG_PAGE_ID) ?>">Widerrufsbelehrung</a></p>
                    <p><a href="<?= get_page_link(DATENSCHUTZ_PAGE_ID) ?>">Datenschutz</a></p>
                    <p><a href="<?= get_page_link(IMPRESSUM_PAGE_ID) ?>">Impressum</a></p>
                    <p><a href="<?= get_page_link(AGB_PAGE_ID) ?>">AGB</a></p>
                </div>
            </div>
            <div>
                <div>
                    <h2>Anmeldung</h2>
                    <p><a href="<?= get_page_link(LOGIN_PAGE_ID) ?>">Kundenlogin</a></p>
                    <p><b>Probleme bei der Anmeldung?</b></p>
                    <p>Sende uns bitte ein Email an</p>
                    <p><a href="mailto:<?= IT_SUPPORT_EMAIL ?>"><?= IT_SUPPORT_EMAIL ?></a></p>
                    <p>Vielen Dank!</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
