<?php ?>

<!doctype html>
<html <?php language_attributes(); ?>>
    <?php get_template_part('templates/head'); ?>
    <body <?php body_class(); ?>>
        <?php echo get_template_part('templates/social-media-icons'); ?>
        <div id="page-container">
            <?php get_template_part('templates/menu'); ?>
            <div id="main-area">
                <?php
                    if (isProductCategory(DELIVERY_CATEGORY_SLUG)) {
                        get_template_part('templates/lieferservice-header');
                    }
                    if (isProductCategory(TICKET_CATEGORY_SLUG)) {
                        $eventCat = getProductCategorySlug();
                        if (!empty($eventCat)) {
                            get_template_part("templates/veranstaltungen/header-${eventCat}");
                        }
                    }
                ?>
