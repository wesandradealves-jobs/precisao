function _mobileNavigation(e) {
    $(e).toggleClass("tcon-transform"),
    $(e).closest($(".header")).find(".navigation.-mobile").toggleClass("-on")
}
function _closeMenu(){
    $(".tcon-transform").removeClass("tcon-transform"),
    $(".-on").removeClass("-on")    
}
function init_map(){
    var myOptions = {
      zoom:17,
      center: new google.maps.LatLng(-23.5676529,-46.5489975), 
      disableDefaultUI: true,
      mapTypeId: google.maps.MapTypeId.TERRAIN
    };
    map = new google.maps.Map(document.getElementById('googleMap'), myOptions);
    marker = new google.maps.Marker({
        map: map,position: new google.maps.LatLng(-23.5676529,-46.5489975)
    });
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
    google.maps.event.addDomListener(window, 'load', init_map);
});
      
      