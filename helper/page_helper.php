<?php

function createPageTitle(): string
{

    $suffix = " - " . get_bloginfo('name');

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

    if (is_404()) {
        return "404" . $suffix;
    }

    if (is_category()) {
        return single_cat_title() . $suffix;
    }

    if (empty(single_post_title())) {
        return $suffix;
    }

    return single_post_title() . $suffix;
}

// Merge page blocks into echoable HTML
function merge_inner_blocks($blocks) {
    $html = '';

    foreach ($blocks as $block) {
        if (!empty($block['innerBlocks'])) {
            $html .= merge_inner_blocks($block['innerBlocks']);
        } else if (!empty($block['innerHTML'])) {
            $html .= $block['innerHTML'];
        }
    }

    return $html;
}
