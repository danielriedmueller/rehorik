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

    if (typeof settings === 'undefined') {
        return false;
    }

    const addToCart = (e) => {
        e.preventDefault();

        const me = $(e.currentTarget);
        const $form = me.closest('form.cart');
        const id = me.val();
        const product_id = $form.find('input[name=product_id]').val() || id;
        const product_qty = $form.find('input[name=quantity]').val() || $form.find('select[name=quantity]').val() || 1;
        const variation_id = $form.find('input[name=variation_id]').val() || 0;
        const attributes = $form.find('input:not([name="product_id"]):not([name="quantity"]):not([name="variation_id"]), select, button, textarea').serializeArrayAll() || [];

        $.ajax({
            type: 'post',
            url: settings.ajax_url,
            data: {
                action: 'rehorik_ajax_add_to_cart',
                nonce: settings.add_nonce,
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
                if (response.error && response.redirect_url) {
                    window.location = response.redirect_url;
                } else {
                    $(document.body).trigger('added_to_cart', [
                        response.fragments,
                        response.cart_hash,
                        me
                    ]);
                }
            }
        });
    }

    const updateCart = (e) => {
        // Is there a submit button?
        $submitButton = $('button[name="update_cart"]');
        if ($submitButton.length) {
            $submitButton.trigger('click');
        } else {
            // No submit button? Do ajax update.
            const me = $(e.currentTarget);
            const cart_item_key = me.attr('name');
            const cart_item_value = me.val();
            const miniCart = me.parents('#rehorik-mini-cart');
            $.ajax({
                type: 'post',
                url: settings.ajax_url,
                data: {
                    action: 'rehorik_ajax_update_cart',
                    nonce: settings.update_nonce,
                    cart_item_key: cart_item_key,
                    cart_item_value: cart_item_value,
                },
                beforeSend: function (response) {
                    miniCart.addClass('loading').removeClass('updated');
                },
                complete: function (response) {
                    miniCart.removeClass('loading').addClass('updated');
                },
                success: function (response) {
                    if (response.error && response.redirect_url) {
                        window.location = response.redirect_url;
                    } else {
                        $(document.body).trigger('added_to_cart', [
                            response.fragments,
                            response.cart_hash,
                            me
                        ]);
                    }
                }
            });
        }
    }

    $(document).on('click', 'button.single_add_to_cart_button:not(.disabled)', addToCart);
    $(document).on('change', 'select.rehorik-quantity:not(.disabled)', updateCart);
})(jQuery);
