$(window).scroll(function(event){
    var st = $(this).scrollTop();
    $( 'section' ).each(function() {
        if($(this).offset().top >= st + $('.header').outerHeight() * 5){
            $(this).removeClass('-animated');
        } else {
            $(this).addClass('-animated');
        }
    });
}); 