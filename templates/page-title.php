<?php
$title = get_the_title();

if (is_woocommerce()) {
    $title = woocommerce_page_title(false);
}

if (is_cart() || is_checkout()) {
    $title = get_the_title();
}

if (tribe_is_event()
    || tribe_is_event_category()
    || tribe_is_in_main_loop()
    || tribe_is_view()
    || 'tribe_events' == get_post_type()
    || is_singular('tribe_events')) {
    $title = "Veranstaltungen";
}
?>
<div class="page-title-outer"><div class="page-title"><h1><?= $title ?></h1></div></div>