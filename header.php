<?php ?>

<!doctype html>
<html <?php language_attributes(); ?>>
    <?php get_template_part('templates/head'); ?>
    <body <?php body_class(); ?>>
        <?php get_template_part('templates/social-media-icons'); ?>
        <div id="page-container">
            <?php
                get_template_part('templates/menu');
                if (isProductCategory(DELIVERY_CATEGORY_SLUG)) {
                    get_template_part('templates/lieferservice-header');
                }
                if (isProductCategory(TICKET_CATEGORY_SLUG)) {
                    $eventCat = getProductCategorySlug();
                    if (!empty($eventCat)) {
                        get_template_part("templates/veranstaltungen/header-${eventCat}");
                    }
                }
                get_template_part('templates/page-title');
                if (is_cart()) {
                    get_template_part('templates/cart-header');
                    wc_add_notice("Aufgrund von Lieferproblemen beim Rohkaffe kommt es bei einigen Kaffeesorten zu einer Versandverzögerung.
        Wir bitten um Verständnis.");
                }
            ?>
            <div class="container flex">
