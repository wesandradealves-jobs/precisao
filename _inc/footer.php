    <footer class="footer">
        <div class="container">
          <?php if($basename == 'login') : ?>
          <p class="copyright">&#x00A9; Copyright <?php echo date('Y'); ?> - <?php echo $ctitulo; ?></p>
          <?php else : ?>
            <div>
              <p class="copyright">&#x00A9; Copyright <?php echo date('Y'); ?> - <?php echo $ctitulo; ?> - Todos os direitos</p>
              <ul class="stamps">
                <li>
                  <p>Developed by SD</p>
                </li>
                <li>
                  <p>W3C | HTML5</p>
                </li>
              </ul>
            </div>
            <?php include('_inc/components/social_networks.php'); ?>
          <?php endif; ?>
        </div>
      </footer>
    </div> 
    <script defer src="assets/js/vendors.js"></script>
    <noscript>Seu Navegador pode não aceitar javascript.</noscript>
    <script defer src="assets/js/commons.js"></script>
    <noscript>Seu Navegador pode não aceitar javascript.</noscript>
    <?php if($MAPS) : ?>
    <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyC5QMfSnVnSCcmkFag0ygrXzj2QJ9usEG4'></script>
    <?php
      $mapsTPL = "<script>";
        $mapsTPL .= "function init_map(){";
          $mapsTPL .= "var myOptions = {";
              $mapsTPL .= "zoom:17,";
              $mapsTPL .= "center: new google.maps.LatLng(".$MAPS."),"; 
              $mapsTPL .= "disableDefaultUI: true,";
              $mapsTPL .= "mapTypeId: google.maps.MapTypeId.TERRAIN";
            $mapsTPL .= "};";
            $mapsTPL .= "map = new google.maps.Map(document.getElementById('googleMap'), myOptions);";
            $mapsTPL .= "marker = new google.maps.Marker({";
              $mapsTPL .= "map: map,position: new google.maps.LatLng(".$MAPS.")";
              $mapsTPL .= "});";
        $mapsTPL .= "}";
        $mapsTPL .= "google.maps.event.addDomListener(window, 'load', init_map);";
        $mapsTPL .= "</script>";

        echo $mapsTPL;
    ?>
    <noscript>Seu Navegador pode não aceitar javascript.</noscript>
    <?php endif; ?>
    <?php if($basename == 'login') : ?>
      <script src='https://www.google.com/recaptcha/api.js' async defer></script>
      <noscript>Seu Navegador pode não aceitar javascript.</noscript>    
    <?php endif; ?>
    <noscript>Seu Navegador pode não aceitar javascript.</noscript>        
    <link rel="stylesheet" href="style.css" type="text/css" media="all" />
  </body>
</html>