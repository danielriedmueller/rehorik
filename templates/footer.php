<?php
if (isProductCategory(TICKET_CATEGORY_SLUG)) {
    get_template_part('templates/footer/veranstaltungen-footer');
}

if (isProductCategory(GIFTS_CATEGORY_SLUG)) {
    get_template_part('templates/footer/geschenke-footer');
}
get_template_part('templates/category/term_description');
get_template_part('templates/newsletter-sign-up');

?>
<footer>
    <div class="container">
        <div>
            <div>
                <div>
                    <h3>Zahlungsarten</h3>
                    <?php get_template_part('templates/payment-methods'); ?>
                </div>
            </div>
            <div>
                <div class="shippingpartner">
                    <h3>Versandpartner</h3>
                    <p>
                        <img alt="Logo DHL" src="<?= get_stylesheet_directory_uri() . '/assets/img/footer/logo-dhl.svg' ?>">
                    </p>
                    <p>
                        <img alt="Logo DPD" src="<?= get_stylesheet_directory_uri() . '/assets/img/footer/logo-dpd.svg' ?>">
                    </p>
                    <p>Versandkosten DHL: 6,5 €</p>
                    <p>Versandkosten DPD: 6,5 €</p>
                    <p>Kostenloser Versand mit DPD ab: <?= FREE_SHIPPING_AMOUNT ?> €</p>
                    <p><small>* Alle Preise sind inkl. MwSt., zzgl. <a href="/versandarten">Versand</a></small></p>
                </div>
            </div>
            <div>
                <div>
                    <h3>Kontakt</h3>
                    <p>Du hast noch Fragen?</p>
                    <p>Einfach anrufen, persönlich vorbeikommen oder schreib uns eine Mail.</p>
                    <p><a href="mailto:<?= CONTACT_MAIL ?>?subject=Kundenanfrage&body=Hallo%20Rehorik-Team,%0D%0A%0D%0AHIER%20STEHT%20DEINE%20NACHRICHT"><?= CONTACT_MAIL ?></a></p>
                    <p><a href="tel:<?= CONTACT_PHONE ?>"><?= CONTACT_PHONE ?></a></p>
                    <p><a href="/jobs">Jobs & Karriere</a></p>
                </div>
            </div>
            <div>
                <div>
                    <h3>Rechtliches</h3>
                    <p><a href="<?= get_page_link(BARRIEREFREIHEIT_PAGE_ID) ?>">Barrierefreiheit</a></p>
                    <p><a href="<?= get_page_link(WIDERRUFSBELEHRUNG_PAGE_ID) ?>">Widerrufsbelehrung</a></p>
                    <p><a href="<?= get_page_link(DATENSCHUTZ_PAGE_ID) ?>">Datenschutz</a></p>
                    <p><a href="<?= get_page_link(IMPRESSUM_PAGE_ID) ?>">Impressum</a></p>
                    <p><a href="<?= get_page_link(AGB_PAGE_ID) ?>">AGB</a></p>
                </div>
            </div>
            <div>
                <div>
                    <h3>Anmeldung</h3>
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
<?php
if (!is_cart() && !is_checkout()) {
    get_template_part('templates/mini-cart');
}
?>
<?php wp_footer(); ?>
</div>
</body>
</html>
