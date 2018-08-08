<?php 
    require_once('_inc/db.php');
    session_start();
    $basename = substr(strtolower(basename($_SERVER['PHP_SELF'])),0,strlen(basename($_SERVER['PHP_SELF']))-4);
?>

<!DOCTYPE html>
<html lang="pt-br" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>PRECISÃO SERVIÇOS GERAIS</title>
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
  <body <?php echo "class='pg-".(($basename == 'index') ? 'home' : $basename)."'"; ?>> 
    <div id="wrap">