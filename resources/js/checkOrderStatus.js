$(window).on('load', () => {
    if($('[data-order-status]').length) {
        let order_id = $('[data-order-status]').data('orderStatus');

        if(order_id) {
            localStorage.clear();

            localStorage.setItem("order_id", order_id);
            localStorage.setItem("date", new Date().getTime());
        }

        if(localStorage.getItem("orderComplete")) {
            $('[data-order-status-waiting]').addClass('hide');
            $('[data-order-status-confirmed]').removeClass('hide');
        } else {
            loopCheck();
        }
    }
})

function loopCheck() {
    let loop = true;
    let date = localStorage.getItem("date");
    setTimeout(() => {
        checkOrderStatus().then((status) => {
            // 30 represents the minutes to wait
            if(parseInt(date) + 15*60000 <= new Date().getTime() && !localStorage.getItem("notified_offline")) {
                $.ajax({
                    url: `/${localStorage.getItem("order_id")}/notify/offline`,
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });

                localStorage.setItem("notified_offline", true);
            }

            if(parseInt(date) + 30*60000 <= new Date().getTime()) {
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
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });
            }

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

            if(loop) {
                loopCheck();
            }
        });
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
