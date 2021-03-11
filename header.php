<?php ?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-27448557-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-27448557-1');
    </script>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php echo get_template_part('templates/social-media-icons'); ?>
<div id="page-container">
<header class="rehorik-header">
    <?= get_template_part('templates/hamburger'); ?>
    <?php wp_nav_menu(['theme_location' => 'main']); ?>
    <?= get_template_part('templates/cart-total'); ?>
    <?php if (is_active_sidebar('productsearch')) {
        dynamic_sidebar('productsearch');
    } ?>
</header>
<div id="et-main-area">
<?php do_action( 'et_before_main_content' ); ?>