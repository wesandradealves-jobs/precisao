<?php 
    $idletime=900; //15 minutos
    if (time()-$_SESSION['timestamp']>$idletime){
        // session_destroy();
        // session_unset();
        header("Location: ../_inc/logout.php?expire=1");
    } else {
        $_SESSION['timestamp']=time();
    }
?>