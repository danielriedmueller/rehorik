<div id="top-bar">
    <div class="left">
        <div class="help-icon">Hilfe & Kontakt: <?= CONTACT_PHONE ?></div>
    </div>
    <div class="center">
        <div class="bean-icon">Mit <span></span> aus Regensburg</div>
        <div class="shipping-icon">Versandkostenfrei ab <?= FREE_SHIPPING_AMOUNT ?> €</div>
    </div>
    <div class="right">
        <?php
        if (is_active_sidebar('productsearch')) {
            dynamic_sidebar('productsearch');
        }
        get_template_part('templates/header/cart-total');
        foreach (wp_get_nav_menu_items('top-bar') as $item) {
            echo sprintf('<a href="%s" class="%s">%s</a>', $item->url, implode(' ', $item->classes), $item->title);
        }
        ?>
    </div>
</div>