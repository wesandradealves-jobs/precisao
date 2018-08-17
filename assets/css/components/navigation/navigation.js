if($('body').is('.pg-home')){
    $('.navigation li')
    .find('a')
    .click(function(e) {
        if (/#/.test(this.href)) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: ($(window).width() > 814) ? $($.attr(this, 'href')).offset().top - $(".header").outerHeight() : $($.attr(this, 'href')).offset().top - 134
                // scrollTop: $($.attr(this, 'href')).offset().top - $(".header").outerHeight()
            }, 500);                    
        }
    }); 
} else {
    $( '.navigation ul li a' ).each(function(e) {
        if (/#/.test(this.href)) {
            $(this).attr("href", "./" + '#' + $(this).attr('href').split('#').pop())
        }
    });
}