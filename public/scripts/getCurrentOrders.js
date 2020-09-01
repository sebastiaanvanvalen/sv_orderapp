$(document).ready(function () {

    $.ajax({
        type: 'GET',
        url : '/testing/testsmitenvoogt/application/main.php',
        headers: {
            'Authorization': 'Bearer ' + $('.csrf_token').val(),
            'tokenType'    : 'BinQB98',
            'switchkey'    : 'getorders',
            'requesttype'  : 'currentorders'
        },
        async      : true,
        contentType: "application/json"
    }).done(function (data) {
        let orders = JSON.parse(data)
        createCurrentOrders(orders)
        // console.log(data)
    })
        .fail(function () {
            alert("getorders failed");
        });
})

function euroFormatter(num) {
    var formatter = new Intl.NumberFormat('nl-NL', {
        style   : 'currency',
        currency: 'EUR',
    });
    return formatter.format(num);
}

setInterval(function() {
    location.reload();
  }, 300000);

function timeFormat(time) {
    return (time.getMinutes() < 10 ? '0' : '') + time.getMinutes();
}

function createCurrentOrders(orders) {
    let count = 0;

    for (var x = 0; x < orders.length; x++) {
        let pt              = orders[x][0].pickup_time;
        let message         = '';
        let pickUpTime      = new Date(pt);
        let pickUpTimeAlt   = pickUpTime.getDate() + '-' + pickUpTime.getMonth() + '  ' + pickUpTime.getHours() + ':' + timeFormat(pickUpTime);

        if (orders[x][0].process_status == '0') {
            message = 'unchecked'
        } else {
            message = 'checked';
        }

        let headerTemplate = `
        <div class="order plain-order today ${message}" id="${orders[x][0].order_id}">
            <div class="ticket-header">
                <div class="order-details">
                    <div class="header-left">
                        <div class="pickup-time">Afhaaltijd: <span>${pickUpTimeAlt}<span></div>
                        <div class="guest-name">${orders[x][1][0].firstname} ${orders[x][1][0].prefix} ${orders[x][1][0].lastname}
                        </div>
                    </div>
                    <div class="header-right">
                        <div class="order-number">601-${orders[x][0].order_id}</div>
                    </div>
                </div>
            </div>
        </div>`;

        if (orders[x][0].process_status == '0') {
            $(".unchecked-orders").append(headerTemplate);
        } else {
            $(".checked-orders").append(headerTemplate);
        }
        count++   
    }
}

function showOrder(orders){

    $(".order-wrapper").empty();
    $(".order-modal").show();

    let message         = '';
    let headerTemplate  = '';
    let itemsTemplate   = '';
    let pt              = orders[0][0][0].pickup_time;
    let pickUpTime      = new Date(pt);
    let pickUpTimeAlt   = pickUpTime.getHours() + ':' + timeFormat(pickUpTime);

    if ( orders[0][0][0].process_status == '0') {
        message = 'today unchecked';
    } else {
        message = 'today checked';
    }

    headerTemplate = `
    <div class="order ${message}" id="">
        <div class="ticket-header">
            <div class="order-details">
                <div class="header-left">
                    <div class="pickup-time">Pickup: <span>${pickUpTimeAlt}<span></div>
                    <div class="guest-name">${orders[0][1][0].firstname} ${orders[0][1][0].prefix} ${orders[0][1][0].lastname}
                    </div>
                </div>
                <div class="header-right">
                    <div class="order-number">NR:601-${orders[0][0][0].order_id}</div>
                </div>
            </div>
        </div>
        <div class="ticket-main">
            <div class="guest-details">
                <div class="info">
                    <div class="order-time">Besteld op: ${orders[0][1][0].create_time}</div>
                    <div class="guest-email">email: ${orders[0][1][0].email}</div>
                    <div class="guest-phone">tel: ${orders[0][1][0].phone}</div>
                </div>
                <div class="status-details">
                    <div class="box-info">
                        <div class="box checked-box" id="${orders[0][0][0].order_id}">
                            <button class="checked-button btn btn-secondary">Invoeren</button>
                            <div class="is-v">
                                <div class="v">V</div>
                            </div>
                        </div>
                        <div class="box canceled-box" id="${orders[0][0][0].order_id}">
                        <button class="cancel-button btn btn-secondary">Cancel</button>
                            <div class="is-v">
                                <div class="v">V</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="guest-comment">${orders[0][0][0].user_comment}</div>
            <div class="order-items">
                <div class="line line-0">
                    <div class="quantity r0"></div>
                    <div class="product-name r0">product</div>
                    <div class="product-addition r0">toevoeging</div>
                    <div class="price r0">prijs</div>
                </div>
            </div>
            <div class="total-price-container">
                <div class="total-price">
                    <div class="tax">
                        <div class="tax-high">BTW 21%: ${euroFormatter(orders[0][0][0].tax_high)}</div>
                        <div class="tax-low">BTW 9%: ${euroFormatter(orders[0][0][0].tax_low)}</div>
                    </div>
                    <div class="price">Totaal: ${euroFormatter(orders[0][0][0].total_price)}</div>
                </div>
            </div>
        </div>
    </div>`;

    $(".order-wrapper").prepend(headerTemplate);

    for (var y = 0; y < orders[0][2].length; y++) {
        itemsTemplate = `
    <div class="order-item">
    <div class="quantity">${orders[0][2][y][1]} x</div>
    <div class="product-name">${orders[0][2][y][0].product_name}</div>
    <div class="product-addition">${orders[0][2][y][0].quantity} ${orders[0][2][y][0].unit}</div>
    <div class="price">${euroFormatter(orders[0][2][y][0].price)}</div>
    </div>`;

    $(".order-items").append(itemsTemplate);
    }

}

// toggle orderdetails
$(document).on('click', (".plain-order"),
    function (e) {
        let id = this.id;

        $.ajax({
            type: 'GET',
            url : '/testing/testsmitenvoogt/application/main.php',
            headers: {
                'Authorization': 'Bearer ' + $('.csrf_token').val(),
                'tokenType'    : 'BinQB98',
                'switchkey'    : 'getorderdetails',
                'id'           : id
            },
            async: true,
            contentType: "application/json"
        }).done(function (data) {
            let order = JSON.parse(data);
            showOrder(order);
            // console.log(data);
        })
            .fail(function () {
                alert("getorders failed");
            });
    })

// "check" and "uncheck" order
$(".order-modal").on('click', '.checked-box',
    function () {
        let id = this.id;
        console.log(id)
        $.ajax({
            type: 'GET',
            url : '/testing/testsmitenvoogt/application/main.php',
            headers: {
                'Authorization': 'Bearer ' + $('.csrf_token').val(),
                'switchkey'    : 'updateorder',
                'tokenType'    : 'BinQB98',
                'orderId'      : id,
                'toStatus'     : 'a',
                'user'         : '503'
            },
            async: true,
        }).done(function (data) {
            console.log(data);
            window.location.href = "currentordersmanager.php";
        }).fail(function () {
            alert("getorders failed");
        });
    })

// "cancel" and "uncancel" order
$(document).on('click', '.canceled-box',
    function () {
        let id = this.id;
        console.log(id)
        $.ajax({
            type: 'GET',
            url : '/testing/testsmitenvoogt/application/main.php',
            headers: {
                'Authorization': 'Bearer ' + $('.csrf_token').val(),
                'switchkey'    : 'updateorder',
                'tokenType'    : 'BinQB98',
                'orderId'      : id,
                'toStatus'     : 'b',
                'user'         : '503'
            },
            async: true,
        }).done(function (data) {
            console.log(data);

            window.location.href = "currentordersmanager.php";
        }).fail(function () {
            alert("getorders failed");
        });

    })
