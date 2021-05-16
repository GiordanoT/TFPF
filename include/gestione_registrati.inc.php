<?php
  require_once( "dbh.inc.php" );
  session_start();

  $email=$_POST["email"];
  $password=$_POST["password"];

  $password = password_hash( $password, PASSWORD_DEFAULT );


  if(registrazione($email,$password,$_POST["nome"],$_POST["cognome"]) == 1){
    header('Location: ../gestionePreferiti.php');
    exit();
  }else if(registrazione($email,$password,$_POST["nome"],$_POST["cognome"]) == 0){
    header('Location: ../registrati.php?errore=email');
    exit();
  }else if(registrazione($email,$password,$_POST["nome"],$_POST["cognome"]) == 2){
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
      if(setData( " INSERT INTO utente (nome,cognome,email,password) VALUES ('".$_POST["nome"]."', '".$_POST["cognome"]."', '".$_POST["email"]."', '".$password."') ")){
        $resultUtente=getData("Select * from utente order by id DESC limit 1");
        $rowUtente=$resultUtente[0];
        
        $_SESSION["nome"] = $rowUtente["nome"];
        $_SESSION["cognome"] = $rowUtente["cognome"];
        $_SESSION["mail"] = $rowUtente["email"];
        
        return 1;
        
      }else return 2;


    }
?>
