(function () {
    var $ = jQuery;
    var $form = $(".variations_form.cart");
    var $priceEl = $('.rehorik-price-unit');
    var $cupOfCoffeEl = $('.rehorik-cup-of-coffee-price');
    var priceArr = null;
    var adjustedPriceArr = null;
    var adjustedPriceString = '';
    var divider = 100;

    var updatePrice = function () {
        priceArr = $priceEl.text().match(/[+-]?([0-9]*[,])?[0-9]+/g);
        adjustedPriceArr = priceArr.map(function(x) {
            var res = x.replace(',', '.') / divider;
            return res.toFixed(2).toString().replace('.', ',') + ' €';
        });
        adjustedPriceString = adjustedPriceArr.join(' - ');
        $cupOfCoffeEl.html(adjustedPriceString)
    }

    $form.on("germanized_variation_data", updatePrice);
    $form.on("germanized_reset_data", updatePrice);
})()