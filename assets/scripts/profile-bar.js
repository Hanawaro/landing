$(document).ready(() => {
    var action = {
        width: $('.profile .action').innerWidth(),
        height: $('.profile .action').innerHeight()
    };

    var info = {
        width: $('.profile .info').innerWidth(),
        height: $('.profile .info').innerHeight()
    };

    $('#close').click(function() {
        setTimeout(function(){
            $('.profile').addClass('disabled');
        }, 600)
        $('.profile').addClass('animated');
        hide(action, info);
    })

    $('.profile').click(function(event) {
        if (event.target === $('.info img')[0] && $('.profile').hasClass('disabled')) {
            $('.profile').removeClass('animated');

            setTimeout(function(){
                $('.profile').removeClass('disabled');
            }, 600)
            show(action, info);
        }
    })

    hideWithoutAnimate(action, info);
});

function hide(action, info) {
    $('.profile .info').animate({ height: "4.8em" },
        300, () => {
            $('.profile .info').animate({ width: "4.8em" }, 300);
        }
    );
    $('.profile .info > div > div').fadeOut(500);
    $('.profile .action').animate(
        {
            padding: "0em 1.5em",
            height: "0",
        }, 300
    );
}

function hideWithoutAnimate(action, info) {
    $('.profile').addClass('init');
    $('.profile').addClass('disabled');
    $('.profile').addClass('animated');

    $('.profile .info').css('height', '4.8em');
    $('.profile .info').css('width', '4.8em');
    $('.profile .info > div > div').fadeOut(0);
    $('.profile .action').css('padding', '0em 1.5em');
    $('.profile .action').css('height', '0');

    $('.profile').removeClass('invisible');
}

function show(action, info) {
    $('.profile .info').animate(
        {
            height: info.height,
            width: info.width
        }, 300, () => {
            $('.profile .info > div > div').fadeIn(300);
            $('.profile .action').animate(
                {
                    padding: "0.7em 1.5em",
                    height: action.height,
                }, 300
            );
        }
    );
}