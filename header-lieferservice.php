<?php ?>

<!doctype html>
<html <?php language_attributes(); ?>>
    <?php get_template_part('templates/head'); ?>
    <body <?php body_class(); ?>>
        <?php echo get_template_part('templates/social-media-icons'); ?>
        <div id="page-container">
            <?php get_template_part('templates/menu'); ?>
            <div id="et-main-area">
                <?php
                get_template_part('templates/lieferservice-header');
                do_action( 'et_before_main_content' );
                ?>