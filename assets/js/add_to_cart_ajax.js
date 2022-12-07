(function ($) {
    $.fn.serializeArrayAll = function () {
        var rCRLF = /\r?\n/g;
        return this.map(function () {
            return this.elements ? jQuery.makeArray(this.elements) : this;
        }).map(function (i, elem) {
            var val = jQuery(this).val();
            if (val == null) {
                return val == null
                //next 2 lines of code look if it is a checkbox and set the value to blank
                //if it is unchecked
            } else if (this.type == "checkbox" && this.checked === false) {
                return {name: this.name, value: this.checked ? this.value : ''}
                //next lines are kept from default jQuery implementation and
                //default to all checkboxes = on
            } else {
                return jQuery.isArray(val) ?
                    jQuery.map(val, function (val, i) {
                        return {name: elem.name, value: val.replace(rCRLF, "\r\n")};
                    }) :
                    {name: elem.name, value: val.replace(rCRLF, "\r\n")};
            }
        }).get();
    };

    $(document).ready(function ($) {
        if (typeof wc_add_to_cart_params === 'undefined') {
            return false;
        }

        $('.single_add_to_cart_button:not(.disabled)').on('click', function (e) {
            e.preventDefault();

            const me = $(this);
            const $form = me.closest('form.cart');
            const id = me.val();
            const product_id = $form.find('input[name=product_id]').val() || id;
            const product_qty = $form.find('input[name=quantity]').val() || $form.find('select[name=quantity]').val() || 1;
            const variation_id = $form.find('input[name=variation_id]').val() || 0;
            const attributes = $form.find('input:not([name="product_id"]):not([name="quantity"]):not([name="variation_id"]), select, button, textarea').serializeArrayAll() || [];

            $.ajax({
                type: 'post',
                url: wc_add_to_cart_params.ajax_url,
                data: {
                    action: 'rehorik_ajax_add_to_cart',
                    product_id: product_id,
                    quantity: product_qty,
                    variation_id: variation_id,
                    attributes: attributes
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
