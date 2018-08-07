<?php
    session_start(); 
    include_once("db.php");    
    if((isset($_POST['login']))){
        // Validacao captcha
            if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
            {
                $secret = '6LcBeGgUAAAAAMU-nI_79ASrPb6wL_QXn69BT3Zx';
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
                $responseData = json_decode($verifyResponse);
                if($responseData->success){
                    $login = mysqli_real_escape_string($conn, $_POST['login']); //Escapar de caracteres especiais, como aspas, prevenindo SQL injection
                    $senha = mysqli_real_escape_string($conn, $_POST['senha']);
                    $senha = md5($senha);
                        
                    $result_usuario = "SELECT * FROM usuarios WHERE login = $login AND senha = '$senha'";
                    $resultado_usuario = mysqli_query($conn, $result_usuario);
                    $resultado = mysqli_fetch_assoc($resultado_usuario);

                    if(isset($resultado)){
                        $_SESSION['login'] = $resultado['login'];
                        $_SESSION['uid'] = $resultado['id'];
                        header("Location: ../profile/index.php");
                    }  else{    
                        $_SESSION['loginErro'] = "Usuário ou senha Inválido";
                        header("Location: ../login.php");
                    }
                } else {
                    $_SESSION['loginErro'] = "Robot verification failed, please try again.";
                    header("Location: ../login.php");
                }
            } else {
                $_SESSION['loginErro'] = "Please re-enter your reCAPTCHA.";
                header("Location: ../login.php");
            }
    } else {
        $_SESSION['loginErro'] = "Usuário ou senha inválido";
        header("Location: ../login.php");
    }
?>