
$(document).ready(function () {
    $(window).scroll(function(event){
        var st = $(this).scrollTop();
        $( 'section' ).each(function() {
            if($(this).offset().top >= st + $('.header').outerHeight() * 5)
                $(this).removeClass('-animated');
            else
                $(this).addClass('-animated');
        });
        if($('.footer').offset().top <= (st + $(".footer").outerHeight() * 6))
            $(".navigation.-mobile").removeClass("-reveal"); 
        else if (st == 0)
            $(".navigation.-mobile").removeClass("-reveal");     
        else 
            $(".navigation.-mobile").addClass("-reveal");
    }); 
});
