$(window).on('load', () => {
    $('#nav-burger').on('click', toggleBurger);
})

function toggleBurger() {
    $('#nav-collapsed').css({
        'right': 0
    });

    $('#nav-collapsed-close').on('click', closeNav);
}

function closeNav() {
    $('#nav-collapsed').css({
        'right': '-100%'
    });
}
