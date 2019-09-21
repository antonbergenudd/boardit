href="{{ route('cart.add', ['product' => $product->id]) }}"

$(window).on('load', () => {
    $('[data-cart-add]').each((index, el) => {
        $(el).on('click', addToCart);
    })

    $('[data-cart-remove]').each((index, el) => {
        $(el).on('click', removeFromCart);
    })
})

function addToCart(e) {
    $.ajax({
        url: `/cart/${e.target.dataset.cartAdd}/add`,
        type: 'GET',
        success: function(res) {
            $(`[data-cart-item-added="${e.target.dataset.cartAdd}"]`).removeClass('hide');
            $(`[data-cart-item-not-added="${e.target.dataset.cartAdd}"]`).addClass('hide');

            recountCart(true);
        }
    });
}

function recountCart(add) {
    let count;
    if(window.innerWidth < 766) {
        count = parseInt($('[data-cart-count-mobile]').text());

        if(add) {
            count++;
        } else {
            count--;
        }

        $('[data-cart-count-mobile]').text(count);
    } else {
        count = parseInt($('[data-cart-count-desktop]').text());

        if(add) {
            count++;
        } else {
            count--;
        }

        $('[data-cart-count-desktop]').text(count);
    }
}

function removeFromCart(e) {
    $.ajax({
        url: `/cart/${e.target.dataset.cartRemove}/remove`,
        type: 'GET',
        success: function(res) {
            $(`[data-cart-item-added="${e.target.dataset.cartRemove}"]`).addClass('hide');
            $(`[data-cart-item-not-added="${e.target.dataset.cartRemove}"]`).removeClass('hide');

            recountCart(false);
        }
    });
}
