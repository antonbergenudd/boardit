$(window).on('load', () => {
    $('[data-pay-method]').each((index, btn) => {
        $(btn).on('click', selectPayMethod);
    })
})

function selectPayMethod(e) {

    $("#select_pay_method").addClass('hide');
    $("#payment_form").removeClass('hide');

    let method = $(e.target).data('payMethod');

    var paymentInput = document.createElement("input");
    paymentInput.value = 1;
    paymentInput.type = 'hidden';

    if(method == 'swish') {
        $('[data-payment-swish]').each((i, el) => {
            $(el).removeClass('hide');
        });

        paymentInput.name = 'payment_by_swish';
    } else if(method == 'card') {
        $('[data-payment-card]').each((i, el) => {
            $(el).removeClass('hide');
        });

        paymentInput.name = 'payment_by_card';
    }

    $("#payment_form").append(paymentInput);

    $('#select_pay_method').toggle();
}
