function _mobileNavigation(e) {
    $(".tcon").toggleClass("tcon-transform"),
    $(".navigation.-mobile").toggleClass("-on")
}
function _closeMenu(){
    $(".tcon-transform").removeClass("tcon-transform"),
    $(".-on").removeClass("-on"),
    $(".-reveal").removeClass("-reveal")    
}
$(document).ready(function () {
    $('.owl-carousel').owlCarousel({
        loop:false,
        center:false,
        autoWidth:false,
        autoplay:false,
        margin: 0,
        nav:true,
        dots:false,
        items: 1,
        navText:false,
        URLhashListener:true        
    });
    $( ".owl-carousel.-webdoor .owl-nav [class*='owl-']" ).wrapAll( "<div class='container' />");
    $(window).scroll(function(event){
        _closeMenu()
    }); 
    $(window).resize(function(){
        _closeMenu()
    });
    $(".login-form").validate({
        rules: {
            login: {
                required: true,
                normalizer: function(value) {
                    return $.trim(value);
                }
            },
            senha: {
                required: true
            }            
        },
        messages: {
            login: {
                required: "Campo obrigatorio."
            },
            senha: {
                required: "Campo obrigatorio."
            }            
        }
    });
    $('.telefone').mask('(99) 9999-9999');
    $('.celular').mask('(99) 9-9999-9999');
    $('.cpf').mask('999.999.999-99');
    $('.data').datepicker();
});
      
      