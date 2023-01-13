(function ($) {
    const $cartButton = $('#rehorik-cart');
    const $overlayButton = $('#mini-cart-overlay');
    const $miniCart = $('#rehorik-mini-cart');
    const $miniCartClose = $('#mini-cart-close');
    const showMiniCart = () => {
        $miniCart.addClass('show');
    };
    const hideMiniCart = () => {
        $miniCart.removeClass('show').removeClass('updated');
    };
    const toggleMiniCart = () => {
        if ($miniCart.hasClass('show')) {
            hideMiniCart();
        } else {
            showMiniCart();
        }
    };
    $cartButton.on('click', toggleMiniCart);
    $overlayButton.on('click', toggleMiniCart);
    $miniCartClose.on('click', hideMiniCart);
    $(document.body).on( 'added_to_cart', () => {
        if ($miniCart.hasClass('show')) {
            $miniCart.addClass('updated');
        } else {
            showMiniCart();
        }
    });
})(jQuery);