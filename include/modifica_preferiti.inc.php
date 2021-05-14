<?php 
  session_start();
  require_once( "dbh.inc.php" );
 

  $cat = $_GET["id"];
  $mail= $_SESSION["mail"];

  $resultUtente=getData("Select * from utente where email='".$mail."'");
  $rowUtente=$resultUtente[0];
  $id=$rowUtente["id"];
      
  
  if($_GET["del"] == "0")
    setData( "INSERT INTO `categoria_preferita`(`id_utente`, `id_categoria`) VALUES ('".$id."','". $cat."') " );
  else  
    setData( "DELETE FROM `categoria_preferita` WHERE id_categoria = '".$cat."' && id_utente='".$id."'" );
  header('Location: ../gestione_preferiti.php');
 

?>
