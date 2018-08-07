<?php
    session_start();    
    unset(
        $_SESSION['uid'],
        $_SESSION['login'],
        $_SESSION['updateSucess'],
        $_SESSION['senha']
    );    
    if(!isset($_GET['action'])){
        $_SESSION['logindeslogado'] = "Deslogado com sucesso";
    } else {
        $_SESSION['logindeslogado'] = "Sua senha foi alterada. Por favor, entre novamente.";
    }
    //redirecionar o usuario para a página de login
    header("Location: ../login.php");
?>