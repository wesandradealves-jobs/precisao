<?php 
    session_start();
    echo "Usuario: ". $_SESSION['login'];      
?>

<a href="logout.php">Sair</a>