<?php
/**
 * Adds mobile nav.
 */
add_action('et_header_top', function() {
    if (is_customize_preview() || ('slide' !== et_get_option('header_style', 'left') && 'fullscreen' !== et_get_option('header_style', 'left'))) {
        echo '<div id="rehorik-mobile-nav"><div class="mobile_nav closed"><span class="mobile_menu_bar mobile_menu_bar_toggle"></span></div></div>';
    }
});