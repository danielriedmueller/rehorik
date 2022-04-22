<?php
get_header();
?>
    <div class="page-title-outer">
        <div class='page-title'><h1>Mein Konto</h1></div>
    </div>
    <div class="container">
        <?php echo do_shortcode('[woocommerce_my_account]') ?>
    </div>
<?php get_footer(); ?>