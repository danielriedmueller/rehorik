<?php

if (is_woocommerce() && is_active_sidebar('productsearch')) {
    $pageTitle = woocommerce_page_title(false);
    ?>
        <div class="page-title-outer">
            <div class='page-title'>
                <h1><?php echo $pageTitle ?></h1>
                <?php if (is_active_sidebar('productsearch')) {
                    dynamic_sidebar('productsearch');
                } ?>
            </div>
        </div>
    <?php
}


if (is_cart() || is_checkout()) {
    $pageTitle = get_the_title();
    echo "<h1 class='page-title'>${pageTitle}</h1>";
}