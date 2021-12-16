const currentClass = '.current';
const visibleClass = '.visible';
const invisibleClass = '.invisible';
const transitionSelector = 'transition';

const runnerClass = '.carousel-runner';
const infoClass = '.info-runner';

$(document).ready(() => {

    // default values
    const carousel = $(runnerClass);
    const carouselUnitsClone = carousel.children().clone();

    // init left and right clones to infinite slide
    carousel.children().first().before(
        carouselUnitsClone.clone()
            .addClass(invisibleClass.replace('.', ''))
            .removeClass(visibleClass.replace('.', ''))
            .removeClass(currentClass.replace('.', ''))
    );

    carousel.children().last().after(
        carouselUnitsClone.clone()
            .addClass(invisibleClass.replace('.', ''))
            .removeClass(visibleClass.replace('.', ''))
            .removeClass(currentClass.replace('.', ''))
    );

    // set events on click arrow
    $('.next-arrow-btn').click(() => { shiftSlide(-1) });
    $('.previous-arrow-btn').click(() => { shiftSlide(1) });

    // set current info (calculate from current carousel unit)
    setInfo();

});

function shiftSlide(direction) {

    // default values
    const carousel = $(runnerClass);
    const carouselUnitWidth = $(`${runnerClass} ${currentClass}`).innerWidth();

    const currentSelector = currentClass.replace('.', '');
    const visibleSelector = visibleClass.replace('.', '');
    const invisibleSelector = invisibleClass.replace('.', '');

    const current = $(currentClass);

    // exit if animation are processing
    if (carousel.hasClass(transitionSelector)) return;

    // set transition
    $(document).off('mouseup');
    carousel.off('mousemove')
        .addClass(transitionSelector)
        .css('transform','translateX(' + (direction * carouselUnitWidth) + 'px)');


    if (direction === -1) {
        // remove current
        current
            .removeClass(currentSelector)
            .addClass(visibleSelector);

        // set new current
        current.next()
            .removeClass(visibleSelector)
            .addClass(currentSelector);

        // remove old last visible one
        $(visibleClass).first()
            .removeClass(visibleSelector)
            .addClass(invisibleSelector);

        // set new visible one
        $(currentClass).next()
            .removeClass(invisibleSelector)
            .addClass(visibleSelector);
    } else if (direction === 1) {
        // remove current
        current
            .removeClass(currentSelector)
            .addClass(visibleSelector);

        // set new current
        current.prev()
            .removeClass(visibleSelector)
            .addClass(currentSelector);

        // remove old last visible one
        $('.visible').last()
            .removeClass(visibleSelector)
            .addClass(invisibleSelector);

        // set new visible one
        $('.current').prev()
            .removeClass(invisibleSelector)
            .addClass(visibleSelector);
    }

    setTimeout(function() {
        // replace elements when animation has been completed
        // * if its left direction then first replace by last
        // * if its right direction then last replace by first
        if (direction === 1) {
            $(`${runnerClass} > *:first`).before().before($(`${runnerClass} > *:last`));
        } else if (direction === -1) {
            $(`${runnerClass} > *:last`).after().after($(`${runnerClass} > *:first`));
        }


        // remove transition class and set default state
        carousel.removeClass(transitionSelector)
        carousel.css('transform','translateX(0px)');

    }, $(runnerClass).css('transition-duration').replace('s', '') * 1000); // duration from runner transition

    // set info (its invisible by default and need to set current)
    setInfo();
}

function setInfo() {
    const info = $(infoClass);

    // start animation by set invisible runner
    info.css('opacity', '0');

    setTimeout(function () {
        // get current class name in carousel runner
        const addedClass = $(`${runnerClass} ${currentClass}`).attr('class').split(/\s+/)[0];

        // end animation with replacing with new current unit and showing it
        info.children().first().before($(`${infoClass} .${addedClass}`));
        info.css('opacity', '1');

    }, info.css('transition-duration').replace('s', '') * 1000); // duration from info runner transition
}