$(document).ready(function () {

$(".current").on('click',
    function(){
        window.location.href='currentordersmanager.php';
    })

$(".canceled").on('click',
    function(){
        window.location.href='cancelmanager.php';
    })

$(".future").on('click',
    function(){
        window.location.href='futuremanager.php';
    })

$(document).on("click",
    function(e){
        if(!$(e.target).closest(".order-wrapper").length || $(e.target).closest(".hide-btn").length){
            $(".order-modal").hide();
        }
    });

})