$(window).on('load', () => {
    lockSubmit();

    $('[data-validate-required]').each((index, el) => {
        $(el).on('input', required);
    })

    $('[data-validate-email]').each((index, el) => {
        $(el).on('input', email);
    })

    $('[data-validate-checkbox]').each((index, el) => {
        $(el).on('click', checkbox);
    })

    $('[data-validate-city]').each((index, el) => {
        $(el).on('input', city);
    })
})

function validateEmail(el) {
    var emailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return emailRegex.test(el.value)
}

function validateCity(el) {
    return el.value.toLowerCase() == 'lund';
}

function validateRequired(el) {
    return el.value != ''
}

function validateCheckbox(el) {
    return $(el).is(':checked')
}

function required(e) {
    if(! validateRequired(e.target)) {
        setInputInvalid(e.target);
    } else {
        setInputValid(e.target);
    }

    checkValid();
}

function city(e) {
    if(! validateCity(e.target)) {
        setInputInvalid(e.target);
    } else {
        setInputValid(e.target);
    }

    checkValid();
}

function email(e) {
    if(! validateEmail(e.target)) {
        setInputInvalid(e.target);
    } else {
        setInputValid(e.target);
    }

    checkValid();
}

function checkbox(e) {
    if(! validateCheckbox(e.target)) {
        setInputInvalid(e.target);
    } else {
        setInputValid(e.target);
    }

    checkValid();
}

function setInputInvalid(el) {
    $(el).addClass('invalid-input');
    $(el).removeClass('valid-input');
}

function setInputValid(el) {
    $(el).addClass('valid-input');
    $(el).removeClass('invalid-input');
}

function checkValid() {
    let unlock = true;
    $('[data-validate-required]').each((index, el) => {
        if(! validateRequired(el)) {
            unlock = false;
        }
    })

    $('[data-validate-email]').each((index, el) => {
        if(! validateEmail(el)) {
            unlock = false;
        }
    })

    $('[data-validate-checkbox]').each((index, el) => {
        if(! validateCheckbox(el)) {
            unlock = false;
        }
    })

    $('[data-validate-city]').each((index, el) => {
        if(! validateCity(el)) {
            unlock = false;
        }
    })

    if(unlock) {
        unlockSubmit();
    } else {
        lockSubmit();
    }
}

function lockSubmit() {
    $('[data-validate-submit]').addClass('lock-submit')
}

function unlockSubmit() {
    $('[data-validate-submit]').removeClass('lock-submit');
}
