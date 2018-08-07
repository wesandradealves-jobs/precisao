<?php
    session_start();    
    unset(
        $_SESSION['uid'],
        $_SESSION['login'],
        $_SESSION['updateSucess'],
        $_SESSION['senha']
    );    
    // session_destroy();
    // session_unset();    
    if(!isset($_GET['action']) && !isset($_GET['expire'])){
        $_SESSION['logindeslogado'] = "Deslogado com sucesso";
    } else if(isset($_GET['expire'])){
        $_SESSION['logindeslogado'] = "Deslogado por tempo de inatividade. Por favor, entre novamente.";
    } else {
        $_SESSION['logindeslogado'] = "Sua senha foi alterada. Por favor, entre novamente.";
    }
    //redirecionar o usuario para a página de login
    header("Location: ../login.php");
?>