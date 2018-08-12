<?php 
    include_once('db.php');
    session_start();

    $basename = substr(strtolower(basename($_SERVER['PHP_SELF'])),0,strlen(basename($_SERVER['PHP_SELF']))-4);
    
    if(isset($_SESSION['login']) && $basename == 'login'){
      header("Location: profile/index.php");
    }

    $config = $conn->prepare("SELECT `logo`, `favico`, `titulo` FROM `smtp` ORDER BY id");
    $contato = $conn->prepare("SELECT `telefone`, `email`, `endereco`, `maps` FROM `contato` ORDER BY id");
    $banner = $conn->prepare("SELECT * FROM `banner` ORDER BY id ASC");
    $portfolio_comercial = $conn->prepare("SELECT `text`, `url`, `label` FROM `portfolio_comercial` ORDER BY id");
    $servicos = $conn->prepare("SELECT `id`, `titulo`, `url`, `text` FROM `servicos` ORDER BY id ASC LIMIT 3");
    $artigos = $conn->prepare("SELECT * FROM `artigos` ORDER BY id DESC LIMIT 1");
    $redes_sociais = $conn->prepare("SELECT * FROM `redes_sociais` ORDER BY id ASC");

    $fetchServicosPage = $conn->query("SELECT * FROM `paginas` WHERE `slug` = 'servicos' LIMIT 1");
    $fetchArtigosPage = $conn->query("SELECT * FROM `paginas` WHERE `slug` = 'artigos' LIMIT 1");
    $fetchEmpresaPage = $conn->query("SELECT * FROM `paginas` WHERE `slug` = 'a-empresa' LIMIT 1");

    if($config){
        $config->execute();
        $config->bind_result($logo, $favico, $ctitulo);
        while($config->fetch()) {
            $logo = $logo;
            $favico = $favico;
            $ctitulo = $ctitulo;
        }
    } if($contato){
        $contato->execute();
        $contato->bind_result($telefone, $email, $endereco, $MAPS);
        while($contato->fetch()) {
            $telefone = $telefone;
            $email = $email;
            $endereco = $endereco;
            $MAPS = $MAPS;
        }
    } if($portfolio_comercial){
        $portfolio_comercial->execute();
        $portfolio_comercial->bind_result($ptxt, $purl, $plabel);
        while($portfolio_comercial->fetch()) {
            $ptxt = $ptxt;
            $purl = $purl;
            $plabel = $plabel;
        }
    }  
    
    if($seo = $conn->query("SELECT * FROM paginas ORDER BY id ASC")) :
        if ($seo->num_rows > 0) :
            while ($row = $seo->fetch_object()) :
                if($row->slug == $basename || ($row->slug == "home" && (!$basename||$basename == "index"))){
                    $headers = $row->headers;
                    $slug = $row->slug;
                    $page = $row->titulo;
                } else if($basename == "login"){
                    $slug = $basename;
                    $page = "Login";
                    $headers = '<meta name="keywords" content="login, precisao, servicos, gerais" />';
                    $headers .= '<meta property="og:description" content="Login Page" />';
                }
            endwhile;
        endif; 
    endif;    
?>

<!DOCTYPE html>
<html lang="pt-br" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title><?php echo $ctitulo." - ".$page  ?></title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="Wesley Andrade - github.com/wesandradealves" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo $ctitulo." - ".$page  ?>" />
    <meta property="og:site_name" content="<?php echo $ctitulo." - ".$page  ?>" />
    <?php echo (isset($headers)) ? html_entity_decode($headers) : ''; ?>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="HandheldFriendly" content="true" />
    <link rel="apple-touch-icon" href="profile/uploads/<?php echo $favico; ?>" />
    <link rel="shortcut icon" type="image/png" href="profile/uploads/<?php echo $favico; ?>" />
  </head>
  <body <?php echo 'class="pg-'.$slug.'"'; ?>> 
    <div id="wrap">