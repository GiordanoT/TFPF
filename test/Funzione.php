<?php

function modifica_preferiti($cat,$mail,$del){
    if(getData("Select * from utente where email='".$mail."'") != 0){
      $resultUtente=getData("Select * from utente where email='".$mail."'");
      $rowUtente=$resultUtente[0];
      $id=$rowUtente["id"];
    }else return 0;


    if($del == "0")
      return setData( "INSERT INTO `categoria_preferita`(`id_utente`, `id_categoria`) VALUES ('".$id."','". $cat."') " );
    else  
      return setData( "DELETE FROM `categoria_preferita` WHERE id_categoria = '".$cat."' && id_utente='".$id."'" );
    
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

    //require "../include/dbh.inc.php";
    //echo registrazione('giordano@mail.it','123','prova','prova');

?>