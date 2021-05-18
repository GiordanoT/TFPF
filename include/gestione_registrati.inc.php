<?php
  require_once( "dbh.inc.php" );
  session_start();
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

  $result = registrazione( $email, $password, $nome, $cognome );
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


  function registrazione($email,$password,$nome,$cognome){
    if( getData( "SELECT email FROM utente where email='{$email}'") != 0){
      $resultEmail = getData( "SELECT email FROM utente where email='{$email}'");
      if( !empty($resultEmail) ) {
        return 0;
      }
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
