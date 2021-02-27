<?php ?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php echo get_template_part('templates/social-media-icons'); ?>
<header class="rehorik-header">
    <?php wp_nav_menu(['theme_location' => 'main']); ?>
    <?php echo get_template_part('templates/cart-total'); ?>
</header>
