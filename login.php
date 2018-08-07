<?php
  session_start();
  if(isset($_SESSION['login'])){
    header("Location: profile/index.php");
  }
?>

<!DOCTYPE html>
<html lang="pt-br" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>PRECISÃO SERVIÇOS GERAIS - Login</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="Wesley Andrade - github.com/wesandradealves" />
    <meta name="description" content="#" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="#" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="PRECISÃO SERVIÇOS GERAIS - Login" />
    <meta property="og:description" content="#" />
    <meta property="og:url" content="#" />
    <meta property="og:site_name" content="PRECISÃO SERVIÇOS GERAIS - Login" />
    <meta property="og:image" content="#" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="HandheldFriendly" content="true" />
    <link rel="canonical" href="#" />
    <link rel="apple-touch-icon" href="#" />
    <link rel="shortcut icon" type="image/png" href="#" />
  </head>
  <body class="pg-login"> 
    <div id="wrap">
      <main class="main">
        <div class="content">
          <form role="form" action="_inc/login.php" class="login-form" method="POST">
            <span>
              <img src="http://127.0.0.1/precisao/assets/imgs/logo.png" alt="PRECISÃO SERVIÇOS GERAIS - Login">
            </span>
            <span>
              <label for="login"><i class="fas fa-user"></i></label>
              <input type="text" name="login" placeholder="LOGIN" />
            </span>
            <span>
              <label for="senha"><i class="fas fa-unlock-alt"></i></label>
              <input type="password" name="senha" placeholder="SENHA" />
            </span>
            <span class="g-recaptcha" data-sitekey="6LcBeGgUAAAAAAP5FLtp7o8S6Bl41Lq6kNMyUPf8"></span>
            <span>
              <input class="btn -submit-button -red" type="submit" value="login" name="login" />
            </span>
            <p class="err-msg">
              <?php 
                if(isset($_SESSION['loginErro'])){
                    echo $_SESSION['loginErro'];
                    unset($_SESSION['loginErro']);
                } else if(isset($_SESSION['logindeslogado'])){
                    echo $_SESSION['logindeslogado'];
                    unset($_SESSION['logindeslogado']);
                }
              ?>
            </p>
          </form>
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
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
    <noscript>Seu Navegador pode não aceitar javascript.</noscript>
    <link rel="stylesheet" href="style.css" type="text/css" media="all" />
  </body>
</html>