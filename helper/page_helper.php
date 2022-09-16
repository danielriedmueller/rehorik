<?php

function createPageTitle($suffix) {
    $suffix = " - " .$suffix;

    if (is_product_category()) {
        return single_cat_title() . $suffix;
    }

    if (is_shop()) {
        return "Shop" . $suffix;
    }

    if (function_exists('tribe_is_event_query')) {
        if (tribe_is_event_query()) {
            return tribe_get_events_title() . $suffix;
        }
    }

    return single_post_title() . $suffix;
}
