<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="pt-br" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>PRECISÃO SERVIÇOS GERAIS - Seja bem vindo(a) <?php echo $_SESSION['login']; ?></title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="Wesley Andrade - github.com/wesandradealves" />
    <meta name="description" content="#" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="#" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="PRECISÃO SERVIÇOS GERAIS" />
    <meta property="og:description" content="#" />
    <meta property="og:url" content="#" />
    <meta property="og:site_name" content="PRECISÃO SERVIÇOS GERAIS" />
    <meta property="og:image" content="#" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="HandheldFriendly" content="true" />
    <link rel="canonical" href="#" />
    <link rel="apple-touch-icon" href="#" />
    <link rel="shortcut icon" type="image/png" href="#" />
  </head>
  <body class="pg-login pg-dashboard"> 
    <div id="wrap">
      <main class="main">
        <div class="content">
            <a href="logout.php">Sair</a>
        </div>
      </main>
      <footer class="footer">
        <div class="content">
          <p class="copyright">&#x00A9; Copyright 2018 - PRECISÃO SERVIÇOS GERAIS</p>
        </div>
      </footer>
    </div> 
    <script defer src="http://127.0.0.1/precisao/assets/js/vendors.js"></script>
    <noscript>Seu Navegador pode não aceitar javascript.</noscript>
    <script defer src="http://127.0.0.1/precisao/assets/js/commons.js"></script>
    <noscript>Seu Navegador pode não aceitar javascript.</noscript>
    <link rel="stylesheet" href="style.css" type="text/css" media="all" />
  </body>
</html>