(function ($) {
    $(document).ready(function ($) {
        $('.single_add_to_cart_button').on('click', function (e) {
            e.preventDefault();

            const me = $(this);
            const $form = me.closest('form.cart');
            const id = me.val();
            const product_qty = $form.find('input[name=quantity]').val() || $form.find('select[name=quantity]').val() || 1;
            const product_id = $form.find('input[name=product_id]').val() || id;
            const variation_id = $form.find('input[name=variation_id]').val() || 0;

            $.ajax({
                type: 'post',
                url: wc_add_to_cart_params.ajax_url,
                data: {
                    action: 'rehorik_ajax_add_to_cart',
                    product_id: product_id,
                    quantity: product_qty,
                    variation_id: variation_id,
                },
                beforeSend: function (response) {
                    me.removeClass('added').addClass('loading');
                },
                complete: function (response) {
                    me.addClass('added').removeClass('loading');
                },
                success: function (response) {
                    if (response.error && response.product_url) {
                        window.location = response.product_url;
                    } else {
                        $(document.body).trigger('added_to_cart', [
                            response.fragments,
                            response.cart_hash,
                            me
                        ]);
                    }
                },
            });
        });
    });
})(jQuery);
