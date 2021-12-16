$(document).ready(function () {

    // to show input range value
    $('.filter #price-range').on('input', function() {
        $('.indicator').html(`${$(this).val()}$`)
    });

    // init strict inputs
    // $('.filter input').each(function () {
    //     $(this).prop('checked', $(this).data()['strict'])
    // });

    // change free input (when its free, price should be disabled)
    $('.filter #free-checkbox').change(function () {
        if ($(this).prop('checked')) {
            $('.filter #price-range').prop('disabled', true);
            $('.indicator').addClass('disabled');
        } else {
            $('.filter #price-range').prop('disabled', false);
            $('.indicator').removeClass('disabled');
        }
    });

    // on change event
    $('.filter input').change(onChange);

    // set when page has loaded (default)
    onChange();
});

function onChange() {

    // init block
    let carts = $('.cart');
    let inputs = $('.filter input[type=checkbox]');

    // if has inputs with empty result carts (when switch state)
    inputs.each(function () {
        let input = $(this);
        let hasOne = false;

        input.addClass('inverse'); // notify that its value of input should be inverse
        carts.each(function () {
            if (isValidCheckbox($(this).data(), false))
                hasOne = true;
        });
        input.removeClass('inverse'); // notify that its value of input should be inverse

        input.prop('disabled', !hasOne);
    });

    inputs.each(function () {
        let input = $(this);
        let hasChange = false;

        carts.each(function () {
            // current state
            let before = isValidCheckbox($(this).data(), false);
            input.addClass('inverse');
            // state if switch state
            let after = isValidCheckbox($(this).data(), false);
            input.removeClass('inverse');

            // if there is changes
            if (before !== after)
                hasChange = true;
        });

        if (!hasChange)
            input.prop('disabled', true);
    });

    // reset carts on screen
    carts.each(function () {
        let cart = $(this);
        if (isValidCheckbox(cart.data(), true))
            cart.show();
        else
            cart.hide();
    });

    // reset range values
    let range = $('.filter #price-range');
    let price = range.attr('max');
    carts.each((index, cart) => {
        let money = $(cart).data()['money'];
        if (money < price && $(cart).is(':visible'))
            price = money;
    });
    range.attr('min', price == 0 ? 1 : price);

}

function isValidCheckbox(data, isFinal) {
    // get all data attributes
    for (let [key, value] of Object.entries(data)) {
        let isKeyValid = true;
        // process all inputs
        $(`.filter input[name=${key}]`).each(function () {
            let input = $(this);

            // if its checkbox
            if (input.attr('type') === "checkbox") {
                let checked = input.hasClass('inverse') ? !input.prop('checked') : input.prop('checked');
                if (input.data()['strict']) {

                    if (isFinal && isNotActive(key))
                        return;

                    if (isNotActive(key))
                        checked = !checked;

                    if (!checked && input.attr('value') == value)
                        isKeyValid = false;
                } else {
                    if (checked && input.attr('value') != value)
                        isKeyValid = false;
                }

            // if its range
            } else if (input.attr('type') === "range") {
                if (value > input.val())
                    isKeyValid = false;
            }
        });
        if (!isKeyValid)
            return false;
    }
    return true;
}

function isNotActive(name) {
    let isActive = false;
    $(`.filter input[name=${name}]`).each(function () {
        let input = $(this);
         if (input.hasClass('inverse') ? !input.prop('checked') : input.prop('checked'))
             isActive = true;
    });
    return !isActive
}