<?php
  session_start();
  require_once( "dbh.inc.php" );
  require_once("functions/Signin.fun.php");
  if( !isset($_POST['registrati']) ){
    header("Location: ../registrati.php");
    exit();
  }
  $email = $_POST["email"];
  $email = addslashes( $email );
  $email = strip_tags( $email );

  $password=$_POST["password"];
  $password = addslashes( $password );
  $password = strip_tags( $password );
  $password = password_hash( $password, PASSWORD_DEFAULT );

  $nome = $_POST["nome"];
  $nome = addslashes( $nome );
  $nome = strip_tags( $nome );

  $cognome = $_POST["cognome"];
  $cognome = addslashes( $cognome );
  $cognome = strip_tags( $cognome );

  $result = Signin( $email, $password, $nome, $cognome );
  if( $result == 1){
    header('Location: ../gestionePreferiti.php');
    exit();
  }else if( $result == 0){
    header('Location: ../registrati.php?errore=email');
    exit();
  }else if( $result == 2){
    header('Location: ../error.php');
    exit();
  }
?>
