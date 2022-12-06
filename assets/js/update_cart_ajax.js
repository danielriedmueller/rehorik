(function ($) {
    $(document).on('change', 'select.rehorik-quantity:not(.disabled)', function () {
        // Is there a submit button?
        $submitButton = $('button[name="update_cart"]');
        if ($submitButton.length) {
            $submitButton.trigger('click');
        } else {
            // No submit button? Do ajax update.

            const me = $(this);
            const cart_item_key = me.attr('name');
            const cart_item_value = me.val();

            $.ajax({
                type: 'post',
                url: wc_add_to_cart_params.ajax_url,
                data: {
                    action: 'rehorik_ajax_update_cart',
                    cart_item_key: cart_item_key,
                    cart_item_value: cart_item_value,
                },
                beforeSend: function (response) {
                    me.removeClass('added').addClass('loading');
                },
                complete: function (response) {
                    me.addClass('added').removeClass('loading');
                },
                success: function (response) {
                },
            });
        }
    });
})(jQuery);