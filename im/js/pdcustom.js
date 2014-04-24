$(document).ready(function () {

    //Remove outline from links
    $("a").click(function () {
        $(this).blur();
    });

    //When mouse rolls over
    $("li.services").mouseover(function () {
        $(".servicesmenu").stop().animate({ height: '331px' }, { queue: false, duration: 600, easing: 'easeOutBounce' })

    });
    //When mouse is removed
    $("li.services").mouseout(function () {
        $(".servicesmenu").stop().animate({ height: '0px' }, { queue: false, duration: 600, easing: 'easeOutBounce' })
    });

});