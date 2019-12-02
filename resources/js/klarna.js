$(window).on('load', () => {
    var client_token = null;
    var data = `{
        "purchase_country": "SE",
        "purchase_currency": "SEK",
        "locale": "sv-SE",
        "order_amount": 10,
        "order_tax_amount": 0,
        "order_lines": [{
            "type": "physical",
            "reference": "19-402",
            "name": "Battery Power Pack",
            "quantity": 1,
            "unit_price": 10,
            "tax_rate": 0,
            "total_amount": 10,
            "total_discount_amount": 0,
            "total_tax_amount": 0
        }]
    }`;
    $.ajax({
        url: 'https://api.playground.klarna.com/payments/v1/sessions',
        headers: {
            'Content-Type': 'application/json',
            "Authorization": "Basic UEsxNDI4MV8yNjRiMmU0NzQ1MWM6VWlSUEFBcXVNaVhweVg0cA=="
        },
        type: 'post',
        dataType: 'json',
        data: data,
        success: function(data){
            // console.log(data);
            localStorage.setItem("klarna_client_token", data.client_token);
        }
    });
})
