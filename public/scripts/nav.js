$(function () {

    $(".menu").on('click', () => {
        $(".lunch-modal").hide();
        $(".menu-sub-sub").hide();
        $(".dropdown").toggle("fast");
        $(".landingtext").toggle();
    })

    $(".bestellen").on('click', (e) => {
        $(".bestellen-content").siblings(".menu-sub-sub").hide();
        $(".bestellen-content").toggle("slow");
    })

    $(".ophalen").on('click', () => {
        $(".ophalen-content").siblings(".menu-sub-sub").hide();
        $(".ophalen-content").toggle("slow");
    })

    $(".contact").on('click', () => {
        $(".contact-content").siblings(".menu-sub-sub").hide();
        $(".contact-content").toggle("slow");
    })

    $(document).on("click",
    function(event){

        if(!$(event.target).closest(".menu").length && !$(event.target).closest(".dropdown").length){
            $(".lunch-modal").hide();
            $(".menu-sub-sub").hide();
            $(".dropdown").hide("fast");
            $(".landingtext").show();
       }
    });
})