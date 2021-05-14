<?php
  require_once( "dbh.inc.php" );
  session_start();

  $email=$_POST["email"];

    //controllo email esistente
    $resultEmail = getData( " SELECT email FROM utente " );
    foreach( $resultEmail as $rowEmail ){
      $emaildb=$rowEmail["email"];
      if(strcmp($emaildb,  $email) == 0 ) {
        header('Location: ../registrati.php?errore=email');
        exit;
      }
    }


    //inserimento db
    if(setData( " INSERT INTO utente (nome,cognome,email,password) VALUES ('".$_POST["nome"]."', '".$_POST["cognome"]."', '".$_POST["email"]."', '".$_POST["password"]."') " )){
      $resultUtente=getData("Select * from utente order by id DESC limit 1");
      $rowUtente=$resultUtente[0];
      
      $_SESSION["nome"] = $rowUtente["nome"];
      $_SESSION["cognome"] = $rowUtente["cognome"];
      $_SESSION["mail"] = $rowUtente["email"];
      
      header('Location: ../gestione_preferiti.php');
      
    }else header('Location: ../erroredb.php');

?>
