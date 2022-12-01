(function ($) {
    $(document).on('change', 'select.rehorik-quantity', function () {
        $('button[name="update_cart"]').trigger('click');
    });
})(jQuery);