<?php

function createPageTitle($suffix) {
    $suffix = " - " .$suffix;
    if (is_product_category()) {
        return single_cat_title() . $suffix;
    }

    if (is_shop()) {
        return "Shop" . $suffix;
    }

    return single_post_title() . $suffix;
}
