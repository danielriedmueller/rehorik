(function ($) {
    const visibleClass = 'show';
    const $cartButton = $('#rehorik-cart');
    const $overlayButton = $('#mini-cart-overlay');
    const $miniCart = $('#rehorik-mini-cart');
    const $updateMessage = $('#rehorik-mini-cart-update-message');
    const toggleMiniCart = () => {
        if ($miniCart.hasClass(visibleClass)) {
            $updateMessage.hide();
        }
        $miniCart.toggleClass(visibleClass)
    };
    $cartButton.on('click', toggleMiniCart);
    $overlayButton.on('click', toggleMiniCart);
    $(document.body).on( 'added_to_cart', () => {
        toggleMiniCart();
        $updateMessage.show();
    })
})(jQuery);