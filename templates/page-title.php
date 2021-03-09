<?php if (is_woocommerce() || is_cart() || is_checkout() ): ?>
<div class="page-title-outer">
    <div class='page-title'>
        <?php
            if (is_woocommerce()) {
                $pageTitle = woocommerce_page_title(false);
                ?><h1><?= $pageTitle ?></h1><?php
            }

            if (is_cart() || is_checkout()) {
                $pageTitle = get_the_title();
                echo "<h1>${pageTitle}</h1>";
            }
        ?>
    </div>
</div>
<?php endif; ?>