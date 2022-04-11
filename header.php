<?php ?>
<!doctype html>
<html <?php language_attributes(); ?>>
    <?php get_template_part('templates/head'); ?>
    <body <?php body_class('rehorik'); ?>>
        <div id="page-container">
            <?php get_template_part('templates/menu'); ?>
            <?php
                if (isProductCategory(MACHINE_CATEGORY_SLUG)) {
                    get_template_part('templates/machine-header');
                }
                if (isProductCategory(TICKET_CATEGORY_SLUG)) {
                    $eventCat = getProductCategorySlug();
                    if (!empty($eventCat)) {
                        get_template_part("templates/veranstaltungen/header-${eventCat}");
                    }
                }
            ?>