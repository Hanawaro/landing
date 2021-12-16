$(document).ready(() => {
    $('#burger-btn').click(() => {
        const header = $('header');
        const html = $('html');
        if (header.hasClass('active')) {
            header.removeClass('active');
            html.css('overflow', 'auto');
        } else {
            header.addClass('active');
            html.css('overflow', 'hidden');
            html.animate({ scrollTop: 0 }, 100);
        }
    });
})