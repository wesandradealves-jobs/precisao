<?php 
    session_start();  
    include_once("db.php");

    $source = $_GET['source'];

    switch($source){
        case "artigo":
            $id = $_GET['id'];
            $file = $_GET['file'];
            $stmt = $conn->prepare("UPDATE `artigos` SET `url` = '' WHERE `artigos`.`id` = $id");
            $stmtProc = $conn->prepare("DELETE FROM artigos WHERE id = ? LIMIT 1");
            if((isset($stmtProc) && $stmtProc !== FALSE) || isset($stmt) && $stmt !== FALSE) {
                $stmt->execute();
                $stmtProc->bind_param("i",$id);
                $stmtProc->execute();
                ($_GET['file']) ? unlink('../profile/uploads/'.$file) : '';
            } else {
                die($conn->error);
            }    
            $stmt->close();
            $stmtProc->close();
            header("Location: ../profile/artigos.php?euid=".$_GET['uid']);
        break;
        case "servico":
            $id = $_GET['id'];
            $file = $_GET['file'];
            $stmt = $conn->prepare("UPDATE `servicos` SET `url` = '' WHERE `servicos`.`id` = $id");
            $stmtProc = $conn->prepare("DELETE FROM servicos WHERE id = ? LIMIT 1");
            if((isset($stmtProc) && $stmtProc !== FALSE) || isset($stmt) && $stmt !== FALSE) {
                $stmt->execute();
                $stmtProc->bind_param("i",$id);
                $stmtProc->execute();
                ($_GET['file']) ? unlink('../profile/uploads/'.$file) : '';
            } else {
                die($conn->error);
            }    
            $stmt->close();
            $stmtProc->close();
            header("Location: ../profile/servicos.php?euid=".$_GET['uid']);
        break;
        case "servico-thumbnail":
            $id = $_GET['id'];
            $file = $_GET['file'];
            $stmt = $conn->prepare("UPDATE `servicos` SET `url` = '' WHERE `servicos`.`id` = $id");
            if(isset($stmt) && $stmt !== FALSE) {
                $stmt->bind_param("i,s", $id, $file);
                $stmt->execute();
                ($_GET['file']) ? unlink('../profile/uploads/'.$file) : '';
            } else {
                die($conn->error);
            }     
            $stmt->close();
            header("Location: ../profile/edit-servico.php?id=".$id."&euid=".$_GET['uid']);
        break;
        case "usuarios":
            if (isset($_GET['id']) && is_numeric($_GET['id']))
            {
                $id = $_GET['id'];
                if ($stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ? LIMIT 1"))
                {
                    $stmt->bind_param("i",$id);
                    $stmt->execute();
                    $stmt->close();
                }
                else
                {
                    echo "ERROR: could not prepare SQL statement.";
                }
                $conn->close();
                if($_GET['uid'] == $id){
                    header("Location: ../_inc/logout.php");
                } else {
                    header("Location: ../profile/usuarios.php?euid=".$_GET['uid']);
                }
            }
        break;
        case "portfolio-comercial":
            $file = $_GET['file'];
            $stmt = $conn->prepare("UPDATE `portfolio_comercial` SET `url` = '' WHERE `portfolio_comercial`.`url` = '".$file."'");
            if(isset($stmt) && $stmt !== FALSE) {
                $stmt->bind_param("s", $file);
                $stmt->execute();
                ($_GET['file']) ? unlink('../profile/uploads/'.$file) : '';
            } else {
                die($conn->error);
            }     
            $stmt->close();
            header("Location: ../profile/portfolio-comercial.php?euid=".$_GET['uid']);
        break;
        case "pagina":
            $id = $_GET['id'];
            $stmt = $conn->prepare("DELETE FROM paginas WHERE id = ? LIMIT 1");
            if((isset($stmt) && $stmt !== FALSE)) {
                $stmt->bind_param("i",$id);
                $stmt->execute();
            } else {
                die($conn->error);
            }    
            $stmt->close();
            header("Location: ../profile/paginas.php?euid=".$_GET['uid']);
        break;
        case "redes-sociais":
            $id = $_GET['id'];
            $stmt = $conn->prepare("DELETE FROM redes_sociais WHERE id = ? LIMIT 1");
            if((isset($stmt) && $stmt !== FALSE)) {
                $stmt->bind_param("i",$id);
                $stmt->execute();
            } else {
                die($conn->error);
            }    
            $stmt->close();
            header("Location: ../profile/redes-sociais.php?euid=".$_GET['uid']);
        break;
        default:
        //
    }
?>