<?php 
    include_once('db.php');
    include_once('config.php');
?>
<!DOCTYPE html>
<html lang="pt-br" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="UTF-8" />
    <base href="/" />

    <?php if(isset($headers) && $headers != '') : ?>

        <?php echo html_entity_decode($headers); ?>
        
    <?php else : ?>

        <title><?php echo $ctitulo." - ".$pgTitulo; ?></title>

        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="robots" content="noindex,nofollow,disallow">
        <meta name="author" content="System Dreams - https://www.system-dreams.com" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:description" content="<?php echo strip_tags($description); ?>">
        <meta property="og:url" content="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
     ?>">
        <meta property="og:image" content="<?php echo (isset($tmp_screenshot)) ? $default_url."profile/tmp/".$tmp_screenshot : $default_url."screenshot.png"; ?>">
        <meta property="og:type" content="website" />
        <meta property="og:title" content="<?php echo $ctitulo." - ".$pgTitulo; ?>" />
        <meta property="og:site_name" content="<?php echo $ctitulo." - ".$pgTitulo; ?>" />

    <?php endif; ?>

    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="HandheldFriendly" content="true" />
    <?php if($favico) : ?>
      <link rel="apple-touch-icon" href="<?php echo $default_url; ?>profile/uploads/<?php echo $favico; ?>" />
      <link rel="shortcut icon" type="image/png" href="<?php echo $default_url; ?>profile/uploads/<?php echo $favico; ?>" />
    <?php endif; ?>
    <link rel="canonical" href="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
 ?>">
  </head>
  <body <?php echo 'class="pg-'.(($slug) ? $slug : $post).'"'; ?>> 
    <div id="wrap">