$(document).ready(function () {


})

function createMessage(x) {
    if (x === ''){
        return
    }
    
    if (x === "0"){
        $(".message-wrapper").show();
        $(".cancel-succeed").show();
        $(".button-wrapper").hide();
        $(".landing-text").hide();
    }
    if (x === "1")  {
        $(".message-wrapper").show();
        $(".cancel-fail").show();
        $(".button-wrapper").hide();
        $(".landing-text").hide();
    }
    if (x === "2")  {
        $(".message-wrapper").show();
        $(".cancel-confirm").show();
        $(".button-wrapper").hide();
        $(".landing-text").hide();
    }
}

let id = $('.order-id-enc').val();

$(".annuleren").on('click',
function(){
    $.ajax({
        type: 'POST',
        url: "/testing/testsmitenvoogt/application/main.php",
        headers: {
            'Authorization' : 'Bearer ' + $('.csrf_token').val(),
            'tokenType'     : 'clientCancelToken',
            'switchkey'     : 'cancelorder',
            'idforcancel'   : id
        },
        async: true,
    }).done(function (data) {
        console.log(data);
        createMessage('0');

    }).fail(function () {
        alert("canceling order failed");
    });
})

let mess = $(".mess").val();

createMessage(mess)
