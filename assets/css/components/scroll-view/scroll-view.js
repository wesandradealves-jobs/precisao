
$(document).ready(function () {
    $(window).scroll(function(event){
        var st = $(this).scrollTop();
        $( 'section' ).each(function() {
            if($(this).offset().top >= st + $('.header').outerHeight() * 5)
                $(this).removeClass('-animated');
            else
                $(this).addClass('-animated');
        });
     
        // if(st > $(".header").outerHeight())
        //     $(".navigation.-mobile").addClass("-reveal")
        // else if($('section#contato').offset().top >= (st + ($(".header").outerHeight() * 2)))
        //     $(".navigation.-mobile").removeClass("-reveal")
        // else 
        //     $(".navigation.-mobile").addClass("-reveal")
    
        if (st > 0)
            $(".navigation.-mobile").addClass("-reveal");
        if ($('section#contato').offset().top < (st + ($(".header").outerHeight() * 2)))
            $(".navigation.-mobile").removeClass("-reveal"); 
    }); 
});
