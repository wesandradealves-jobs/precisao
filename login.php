<?php
  if(isset($_SESSION['login'])){
    header("Location: profile/index.php");
  }
  include("_inc/head.php");
  include("_inc/header.php");
?>
<main class="main">
  <div class="content">
    <form role="form" action="<?php echo $default_url ?>_inc/login.php" class="login-form" method="POST">
      <h1 class="logo">
        <a href="<?php echo $default_url; ?>" title="<?php echo $ctitulo; ?>"><img src="<?php echo $default_url; ?>profile/uploads/<?php echo $logo; ?>" alt="<?php echo $ctitulo; ?>" /></a>
        <!-- <img height="90" src="assets/imgs/logo.png" alt="PRECISÃO SERVIÇOS GERAIS - Login"> -->
      </h1>
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
<?php include("_inc/footer.php"); ?>