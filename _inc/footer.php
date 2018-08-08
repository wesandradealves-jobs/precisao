    <footer class="footer">
        <div class="container">
          <?php if($basename == 'login') : ?>
          <p class="copyright">&#x00A9; Copyright 2018 - PRECISÃO SERVIÇOS GERAIS</p>
          <?php else : ?>
          <div>
            <p class="copyright">&#x00A9; Copyright 2018 - PRECISÃO SERVIÇOS GERAIS - Todos os direitos</p>
            <ul class="stamps">
              <li>
                <p>Developed by SD</p>
              </li>
              <li>
                <p>W3C | HTML5</p>
              </li>
            </ul>
          </div>
          <div>
            <ul class="social-networks">
              <li><a href="#" title="Facebook" class="fab fa-facebook-f"></a></li>
              <li><a href="#" title="RSS" class="fas fa-rss"></a></li>
              <li><a href="#" title="Twitter" class="fab fa-twitter"></a></li>
            </ul>
          </div>
          <?php endif; ?>
        </div>
      </footer>
    </div> 
    <script defer src="assets/js/vendors.js"></script>
    <noscript>Seu Navegador pode não aceitar javascript.</noscript>
    <script defer src="assets/js/commons.js"></script>
    <noscript>Seu Navegador pode não aceitar javascript.</noscript>
    <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyC5QMfSnVnSCcmkFag0ygrXzj2QJ9usEG4'></script>
    <script>
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
      google.maps.event.addDomListener(window, 'load', init_map);
    </script>
    <noscript>Seu Navegador pode não aceitar javascript.</noscript>
    <?php if($basename == 'login') : ?>
      <script src='https://www.google.com/recaptcha/api.js' async defer></script>
      <noscript>Seu Navegador pode não aceitar javascript.</noscript>    
    <?php endif; ?>
    <link rel="stylesheet" href="style.css" type="text/css" media="all" />
  </body>
</html>