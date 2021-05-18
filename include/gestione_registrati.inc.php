<?php
  session_start();
  require_once( "dbh.inc.php" );
  //require_once("../test/Signin.php");
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
  function Signin($email,$password,$nome,$cognome){
    $resultEmail = getData( "SELECT email FROM utente WHERE email='{$email}'");
    if( $resultEmail != 0){
      if( !empty($resultEmail) ) { return 0;}
    }else return 2;
    //inserimento db
    if( setData( " INSERT INTO utente (nome,cognome,email,password) VALUES ( '{$nome}','{$cognome}','{$email}','{$password}') ")){
      $resultUtente=getData("Select * from utente order by id DESC limit 1");
      $rowUtente=$resultUtente[0];
      $_SESSION["nome"] = $rowUtente["nome"];
      $_SESSION["cognome"] = $rowUtente["cognome"];
      $_SESSION["mail"] = $rowUtente["email"];
      return 1;
    }else return 2;
  }
?>
