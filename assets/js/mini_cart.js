(function ($) {
    const visibleClass = 'show';
    const $cartButton = $('#rehorik-cart');
    const $overlayButton = $('#mini-cart-overlay');
    const $miniCart = $('#rehorik-mini-cart');
    const toggleMiniCart = () => {
        if ($miniCart.hasClass(visibleClass)) {
            ('#rehorik-mini-cart-update-message').hide();
        }
        $miniCart.toggleClass(visibleClass)
    };
    $cartButton.on('click', toggleMiniCart);
    $overlayButton.on('click', toggleMiniCart);
    $(document.body).on( 'added_to_cart', () => {

        console.log($('#rehorik-mini-cart-update-message'))
        $('#rehorik-mini-cart-update-message').show();
        $miniCart.addClass(visibleClass);
    })
})(jQuery);