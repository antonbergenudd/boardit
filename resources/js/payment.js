$(window).on("load", () => {

    loadKlarnaContainer();
    var checkoutContainer = document.getElementById('my-checkout-container')
    checkoutContainer.innerHTML = (document.getElementById("KCO").value).replace(/\\"/g, "\"").replace(/\\n/g, "");
    var scriptsTags = checkoutContainer.getElementsByTagName('script')
    for (var i = 0; i < scriptsTags.length; i++) {
        var parentNode = scriptsTags[i].parentNode
        var newScriptTag = document.createElement('script')
        newScriptTag.type = 'text/javascript'
        newScriptTag.text = scriptsTags[i].text
        parentNode.removeChild(scriptsTags[i])
        parentNode.appendChild(newScriptTag)
    }
})

function loadKlarnaContainer() {
    $.ajax({
        url: "https://api.playground.klarna.com/checkout/v3/orders",
        method: "POST",
        contentType:"application/json",
        dataType: "json",
        headers: {
            "Authorization": "Basic " + btoa("PK31935_0640002d7a81:H6h2IVrUFHmiXZRw"),
            "Access-Control-Allow-Origin": "*",
            "Access-Control-Allow-Methods": "DELETE, POST, GET, OPTIONS",
            "Access-Control-Allow-Headers": "Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With",
        },
        crossDomain: true,
        data: JSON.stringify({
            "purchase_country": "SE",
            "purchase_currency": "SEK",
            "locale": "en-SE",
            "order_amount": 500,
            "order_tax_amount": 0,
            "order_lines": [
                {
                    "type": "physical",
                    "reference": "19-402-USA",
                    "name": "Monopol",
                    "quantity": 1,
                    "quantity_unit": "pcs",
                    "unit_price": 500,
                    "tax_rate": 0,
                    "total_amount": 500,
                    "total_discount_amount": 0,
                    "total_tax_amount": 0
                }
                ],
            "merchant_urls": {
                "terms": "https://www.example.com/terms.html",
                "checkout": "https://www.example.com/checkout.html",
                "confirmation": "https://www.example.com/confirmation.html",
                "push": "https://www.example.com/api/push"
            }
        }),
        success: (data) => {
            console.log(data);
        }
    })
}