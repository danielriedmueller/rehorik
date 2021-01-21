<?php
/**
 * Adds page title to the top on woocommerce pages
 */
add_action('et_before_main_content', function () {
    echo get_template_part('templates/page-title');
});


/**
 * Removes breadcrumb.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);