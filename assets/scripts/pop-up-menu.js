$(document).ready(() => {

    const menu = $('.pop-up-menu');
    const button = $('#get-app-btn');

    const loginForm = $('#login-form');
    const registerForm = $('#register-form');
    const resetPasswordForm = $('#reset-password-form');

    const toLogin = $('#to-login-btn');
    const toRegister = $('#to-register-btn');
    const toResetPassword = $('#to-reset-password-btn');

    button.click(function () {
        if (menu.hasClass('redirect')) {
            let protocol = $(location).attr('protocol');
            let hostname = $(location).attr('hostname');
            $(location).attr('href', `${protocol}//${hostname}/profile`);
            return;
        }
        menu.removeClass('disabled');
        $('body').css('overflow', 'hidden');
    })

    menu.click(function(event) {
        if (event.target !== this)
            return;
        menu.addClass('disabled');
        menu.addClass('animation');
        $('body').css('overflow', 'visible');
    })

    setLinks(toLogin, registerForm, loginForm);
    setLinks(toRegister, loginForm, registerForm);
    setLinks(toResetPassword, loginForm, resetPasswordForm);
    setLinks(menu, resetPasswordForm, loginForm);
});

function setLinks(link, from, to) {
    link.click(function (event) {
        if (event.target !== this || from.is(':hidden'))
            return;
        from.fadeOut(200, function () {
            from.hide();
            to.fadeIn(200)
        });
    });
}