$(document).ready(function () {

})

function getStopStatus(){
    $.ajax({
        type: 'GET',
        url: '/testing/testsmitenvoogt/application/main.php',
        headers: {
            'Authorization' : 'Bearer ' + $('.csrf_token').val(),
            'tokenType'     : 'BinQB98',
            'switchkey'     : 'getStopStatus'
        },
        async: true,
    }).done(function (data) {
        setModal(data);
        // console.log(data);
    })
    .fail(function () {
        alert("getting stop status (ajax) failed");
    });
}


$(".stop").on('click',
    function () {
        $.ajax({
            type: 'GET',
            url: '/testing/testsmitenvoogt/application/main.php',
            headers: {
                'Authorization' : 'Bearer ' + $('.csrf_token').val(),
                'tokenType'     : 'BinQB98',
                'switchkey'     : 'stop',
                'user'          : "503"
            },
            async: true,
        }).done(function (data) {
            setModal(data);
            // console.log("stopbtn + " + data)
            location.reload();
        }).fail(function () {
            alert("Stop button (ajax) failed...");
        });
})

function setModal(data){
    if (data == "status0") {
        $(".stop-modal").hide()
    }
    if (data == "status1") {
        $(".stop-modal").show();
    }    
}

getStopStatus();