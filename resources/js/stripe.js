$(window).on("load",function() {
    if($('#payment_form')[0]) {
        var handler = StripeCheckout.configure({
            key: $('[data-env]')[0].dataset.env ? 'pk_test_38fBm3VYGdVl0KiQ8xnutiP2' : 'pk_live_01fyhXs7K9kXx32qtNq1AA1j',
            image: '',
            locale: 'auto',
            allowRememberMe: false,
            token: function(token) {
                var stripeToken = document.createElement("input");
                stripeToken.value = token.id;
                stripeToken.type = 'hidden';
                stripeToken.name = 'stripeToken';

                $('#payment_form').append(stripeToken);

                //document.querySelector('.loading').style.display = 'flex';
                $('#payment_form').submit();
            }
        });

        // Attach listeners to all .paymentTrigger
        $('[data-stripe-pay]').on('click', function(e) {
            e.preventDefault();

            let amount = parseInt(e.target.dataset.stripeAmount);

            // Apply discount
            amount = amount * (1 - ($('input[name="discount_amount"]').val() / 100));

            //Open checkout on click
            handler.open({
                name: 'Boardit',
                description: 'Beställning av spel',
                currency: 'sek',
                amount: amount * 100,
                email: $('input[name="email"]')[0].value,
            });
        });

        // Close Checkout on page navigation:
        window.addEventListener('popstate', function() {
            handler.close();
        });
    }
});
