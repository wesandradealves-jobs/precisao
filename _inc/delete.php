<?php 
    session_start();  
    include_once("db.php");
    if(!isset($_GET['file'])){
        // confirm that the 'id' variable has been set
        if (isset($_GET['id']) && is_numeric($_GET['id']))
        {
            // get the 'id' variable from the URL
            $id = $_GET['id'];
    
            // delete record from database
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
            
            // redirect user after delete is successful
            if($_GET['uid'] == $id){
                header("Location: ../_inc/logout.php");
            } else {
                header("Location: ../profile/usuarios.php?euid=".$_GET['uid']);
            }
        }
        else
        // if the 'id' variable isn't set, redirect the user
        {
            header("Location: ../profile/usuarios.php?euid=".$_GET['uid']);
        }
    } else {
        $file = $_GET['file'];

        if($_GET['type']){
            $id = $_GET['id'];

            $stmt = $conn->prepare("UPDATE servicos SET `url` = '' WHERE `servicos`.`url` = '".$file."'");
            
            if(isset($stmt) && $stmt !== FALSE) {
                $stmt->execute();
                $stmt->close();
                unlink('../profile/uploads/'.$file);
                header("Location: ../profile/edit-servico.php?id=".$id."&euid=".$_GET['uid']);
            } else {
                die($conn->error);
            }        
        } else {
            $stmt = $conn->prepare("UPDATE portfolio_comercial SET `url` = '' WHERE `portfolio_comercial`.`url` = '".$file."'");
        
            if(isset($stmt) && $stmt !== FALSE) {
                $stmt->execute();
                $stmt->close();
                unlink('../profile/uploads/'.$file);
                header("Location: ../profile/portfolio-comercial.php?euid=".$_GET['uid']);
            } else {
                die($conn->error);
            }   
        }
        
    }
?>