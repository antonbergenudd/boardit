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

    $('[data-validate-discount]').each((index, el) => {
        $(el).on('input', discount);
    })

    $('[data-validate-date]').each((index, el) => {
        $(el).on('input', date);
    })

    $('[data-validate-hour]').each((index, el) => {
        $(el).on('input', hour);
    })

    $('[data-validate-minute]').each((index, el) => {
        $(el).on('input', minute);
    })
})

async function validateDiscount(el) {
    return $.ajax({
        url: '/check/discount',
        type: 'post',
        data: {
            code: el.value
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            return data;
        }
    });
}

function validateEmail(el) {
    var emailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return emailRegex.test(el.value)
}

function validateCity(el) {
    return el.value.toLowerCase() == 'lund';
}

function validateDate(el) {
    return new Date(el.value).getTime() >= new Date().getTime();
}

function validateHour(el) {
    return el.value >= 10 && el.value <= 21;
}

function validateMinute(el) {
    return el.value >= 0 && el.value <= 59;
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

async function discount(e) {
    let test = await validateDiscount(e.target).then((amount) => {
        if(! amount) {
            setInputInvalid(e.target);
            e.target.dataset.discount = 0;
            $('input[name="discount_amount"]').val(0);
            $('[data-discount-number]').parent().addClass('hide');
            $('[data-discount-number]').text(0);
        } else {
            setInputValid(e.target);
            $('input[name="discount_amount"]').val(amount);
            $('[data-discount-number]').parent().removeClass('hide');
            $('[data-discount-number]').text(amount);
        }
    });
}

function city(e) {
    if(! validateCity(e.target)) {
        setInputInvalid(e.target);
    } else {
        setInputValid(e.target);
    }

    checkValid();
}

function date(e) {
    if(! validateDate(e.target)) {
        setInputInvalid(e.target);
    } else {
        setInputValid(e.target);
    }

    checkValid();
}

function hour(e) {
    if(! validateHour(e.target)) {
        setInputInvalid(e.target);
    } else {
        setInputValid(e.target);
    }

    checkValid();
}

function minute(e) {
    if(! validateMinute(e.target)) {
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
