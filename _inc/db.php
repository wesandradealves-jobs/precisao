<?php
  $servidor = "localhost";
  $usuario = "root";
  $senha = "";
  $dbname = "demo1380119880";
  
  //Criar a conexao
  $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
  
  if(!$conn){
      die("Falha na conexao: " . mysqli_connect_error());
  }else{
      //echo "Conexao realizada com sucesso";
  }     

  mysqli_set_charset($conn,"utf8");

  require_once('functions.php');
  header('Content-Type: text/html; charset=UTF-8');  
?>