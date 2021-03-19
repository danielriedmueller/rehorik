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

        if (tribe_is_event()
            || tribe_is_event_category()
            || tribe_is_in_main_loop()
            || tribe_is_view()
            || 'tribe_events' == get_post_type()
            || is_singular('tribe_events')) {
            $pageTitle = "events";
            echo "<h1>${pageTitle}</h1>";
        }
        ?>
    </div>
</div>