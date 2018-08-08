<?php 
    session_start();  
    include_once("db.php");
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

?>