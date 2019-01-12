$(window).on('load', () => {
    $('[data-pay-method]').each((index, btn) => {
        $(btn).on('click', selectPayMethod);
    })
})

function selectPayMethod(e) {
    let method = $(e.target).data('payMethod');
    if(method == 'swish') {
        $('#swish').toggle();
    } else if(method == 'card') {
        $('#card').toggle();
    }

    $('#select_pay_method').toggle();
}
