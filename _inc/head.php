<?php 
    include_once('db.php');
    include_once('config.php');
?>

<!DOCTYPE html>
<html lang="pt-br" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title><?php echo $ctitulo." - ".$pgTitulo; ?></title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="Wesley Andrade - github.com/wesandradealves" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo $ctitulo." - ".$pgTitulo; ?>" />
    <meta property="og:site_name" content="<?php echo $ctitulo." - ".$pgTitulo; ?>" />
    <?php echo (isset($headers)) ? html_entity_decode($headers) : ''; ?>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="HandheldFriendly" content="true" />
    <link rel="apple-touch-icon" href="profile/uploads/<?php echo $favico; ?>" />
    <link rel="shortcut icon" type="image/png" href="profile/uploads/<?php echo $favico; ?>" />
  </head>
  <body <?php echo 'class="pg-'.(($slug) ? $slug : $post).'"'; ?>> 
    <div id="wrap">