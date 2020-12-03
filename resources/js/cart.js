// href="{{ route('cart.add', ['product' => $product->id]) }}"

// Hide cart on init
$(document).ready(() => {
    $('.cart-floating').addClass("hide");
})

// Hide cart on scroll
$(window).on('scroll', () => {
    $('.cart-floating').addClass("hide");
})

$(window).on('load', () => {
    $('[data-cart-add]').each((index, el) => {
        $(el).on('click', addToCart);
    })

    initCartListener();

    $('[data-cart-empty]').each((index, el) => {
        $(el).on('click', emptyCart);
    })

    $("#navbar-checkout").hover(() => {
        if($($('[data-cart-count]')[0]).text() > 0) $('.cart-floating').removeClass("hide");
    })
})

function initCartListener() {
    $('[data-cart-remove]').each((index, el) => {
        $(el).on('click', removeFromCart);
    })
}

function addToCart(e) {
    $.ajax({
        url: `/cart/${e.target.dataset.cartAdd}/add`,
        type: 'GET',
        success: function(cartItem) {
            $('[data-cart-count]').each((i, el) => {
                let count = parseInt($(el).text());

                count++;

                $(el).text(count);

                if(count > 0) {
                    $(el).parent().removeClass("hide");
                }
            })

            if(cartItem != "") {
                var placeholderItem = $('[data-cart-item-placeholder] div').clone()[0]
                $(placeholderItem).find("img").attr("src", "/img/games/"+ cartItem[1]["thumbnail"]);
                $(placeholderItem).find("h4").text(cartItem[0]["name"])
                $(placeholderItem).find("[data-cart-item-price]").text(cartItem[0]["price"] + " kr")
                $(placeholderItem).find("[data-cart-remove]").attr("data-cart-remove", cartItem[0]["rowId"])
                $(placeholderItem).find("[data-cart-remove]").on('click', removeFromCart);

                $('[data-cart-items]').append(placeholderItem);
                $('[data-cart-items]').append("<hr style='opacity:0.2'>");

                // Update total
                var previousTotal = parseInt($("[data-cart-total]").text().replace(/\.00$/,''));
                var addItem = parseInt(cartItem[1]["price"]);
                var newTotal = previousTotal + addItem;
                $("[data-cart-total]").text(newTotal + ".00");
            }
            
            // Animate count
            $('[data-cart-count]').parent().animate({
                fontSize: "13px",
                width: "21px",
                height: "21px",
            }, 100).animate({
                fontSize:"10px",
                width: "17px",
                height: "17px"
            }, 100);

            // Animate button
            $(e.target).animate({
                fontSize: "24pt",
            }, 100).animate({
                fontSize:"20pt",
            }, 100);

            $('.cart-floating').removeClass("hide");
        }
    });
}

function emptyCart(e) {
    var items = $("[data-cart-items]").children("div")
    for(var i = 0; i < items.length; i++) {
        if($(items[i]).find("[data-cart-remove]")[0].dataset.cartRemove != "") {
            $(items[i]).next("hr").remove();
            $(items[i]).remove();
        }
    }

    // Update total
    $("[data-cart-total]").text("00.00");
    $('.cart-floating').addClass("hide");

    $('[data-cart-count]').each((i, el) => {
        $(el).text(0);
        $(el).parent().addClass("hide");
    })

    $.ajax({
        url: `/cart/destroy`,
        type: 'GET',
        success: function(res) {}
    })
}

function removeFromCart(e) {
    var parent = e.target.closest("div");
    var cost = parseInt($(parent).find('[data-cart-item-price]').text().replace(' kr',''))
    var cartId = $(parent).find("[data-cart-remove]").data("cartRemove")

    // TODO: change GET to remove
    $.ajax({
        url: `/cart/${cartId}/remove`,
        type: 'GET',
        success: function(res) {
            // Update count
            $('[data-cart-count]').each((i, el) => {
                let count = parseInt($(el).text());

                count--;

                $(el).text(count);

                if(count <= 0) {
                    $(el).parent().addClass("hide");
                }
            })

            // Remove from floating cart
            $(parent).find('[data-cart-remove]').closest("div").next("hr").remove();
            $(parent).find('[data-cart-remove]').closest("div").remove();

            // Update floating cart total
            var previousTotal = parseInt($("[data-cart-total]").text().replace(/\.00$/,''));
            var newTotal = previousTotal - cost;
            
            if(newTotal <= 0) {
                newTotal = 0;
                $('.cart-floating').addClass("hide");
            }

            $("[data-cart-total]").text(newTotal + ".00");
        }
    });
}
