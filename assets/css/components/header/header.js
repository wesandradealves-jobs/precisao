$(document).ready(function () {
    $("header").before($("header").clone(true).addClass("-sticky")); 
    $(window).scroll(function() {
        var t = $(this).scrollTop();
        if (t > 0){
            $(".-sticky").addClass("-stuck");
        } else {
            $(".-sticky").removeClass("-stuck");
        }
    });
});
