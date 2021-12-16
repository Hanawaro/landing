$(document).ready(() => {
    $('#individual-target').click(() => {
        $('#indicator').removeClass('active');

        $('#company-plan-cart').removeClass('active');
        $('#individual-plan-cart').addClass('active');
    });

    $('#company-target').click(() => {
        $('#indicator').addClass('active');

        $('#individual-plan-cart').removeClass('active');
        $('#company-plan-cart').addClass('active');
    })

    $('#print-btn').click(function() {
        let printButton = $(this);
        if (printButton.hasClass('active')) {
            $("body").removeClass("print");
            printButton.removeClass('active');
            printButton.html("Print");
        } else {
            $("body").addClass("print");
            printButton.addClass('active');
            printButton.html("Unprint");
        }
    });
});