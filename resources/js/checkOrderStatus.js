$(window).on('load', () => {
    let el = $('[data-order-status]');

    if(el.length) {
        let order_id = $('[data-order-status]').data('orderStatus')
        if(order_id) {
            localStorage.setItem("order_id", order_id);
        }

        if(localStorage.getItem("orderComplete")) {
            $('[data-order-status-waiting]').addClass('hide');
            $('[data-order-status-confirmed]').removeClass('hide');
        } else {
            loopCheck();
        }
    } else {
        localStorage.removeItem("order_id");
        localStorage.removeItem("orderComplete");
    }
})

function loopCheck() {
    let loop = true;
    setTimeout(() => {
        checkOrderStatus().then((status) => {
            if(status == "true") {
                $('[data-order-status-confirmed]').each((i, el) => {
                    $(el).removeClass('hide');
                });

                $('[data-order-status-waiting]').each((i, el) => {
                    $(el).addClass('hide');
                });

                loop = false;

                localStorage.setItem("orderComplete", true);
            }
        });

        if(loop) {
            loopCheck();
        }
    }, 10000);
}

async function checkOrderStatus() {
    return $.ajax({
        url: `/${localStorage.getItem("order_id")}/status`,
        type: 'get',
        success: function (data) {
            return data;
        }
    });
}
