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

            $('[data-cart-count]').each((i, el) => {
                let count = parseInt($(el).text());

                count++;

                $(el).text(count);

                if(count > 0) {
                    $(el).parent().removeClass('hide');
                }
            })
        }
    });
}

function removeFromCart(e) {
    $.ajax({
        url: `/cart/${e.target.dataset.cartRemove}/remove`,
        type: 'GET',
        success: function(res) {
            $(`[data-cart-item-added="${e.target.dataset.cartRemove}"]`).addClass('hide');
            $(`[data-cart-item-not-added="${e.target.dataset.cartRemove}"]`).removeClass('hide');

            let id = $(e.target).data('cartRemove');
            if($('.full-cart')[0]) {
                let newTotal = parseInt($('[data-cart-total]').text()) - parseInt($(`[data-cart-item="${id}"]`).find('[data-cart-item-price]').text());

                $('[data-cart-total]').text(newTotal);
                $('[data-stripe-amount]').attr('data-stripe-amount', newTotal);

                $(e.target).parent().next().remove();
                $(e.target).parent().remove();
            }

            // Update count
            $('[data-cart-count]').each((i, el) => {
                let count = parseInt($(el).text());

                count--;

                $(el).text(count);

                if(count == 0) {
                    $(el).parent().addClass('hide');
                }
            })
        }
    });
}
