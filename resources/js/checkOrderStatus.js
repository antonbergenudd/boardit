$(window).on('load', () => {
    let el = $('[data-order-status]');

    if(el.length) {
        let order_id = $('[data-order-status]').data('orderStatus')
        if(order_id) {
            localStorage.setItem("order_id", order_id);
            localStorage.setItem("date", new Date().getTime());
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
        localStorage.removeItem("date");
    }
})

function loopCheck() {
    let loop = true;
    let date = localStorage.getItem("date");
    setTimeout(() => {
        checkOrderStatus().then((status) => {
            // 30 represents the minutes to wait
            if(parseInt(date) + 1*60000 <= new Date().getTime()) {
                $('[data-order-status-confirmed]').each((i, el) => {
                    $(el).addClass('hide');
                });

                $('[data-order-status-waiting]').each((i, el) => {
                    $(el).addClass('hide');
                });

                $('[data-order-status-failed]').each((i, el) => {
                    $(el).removeClass('hide');
                });

                $.ajax({
                    url: `/${localStorage.getItem("order_id")}/status/failed`,
                    type: 'get'
                });
            } else if(status == "true") {
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
