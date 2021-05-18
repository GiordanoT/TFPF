<?php
  session_start();
  require_once( "dbh.inc.php" );
  if( !isset($_POST['preferiti']) ){
    //header("Location: ../gestionePreferiti.php");
    //exit();
  }

  $cat = $_POST["cat"];
  $mail= $_SESSION["mail"];
  $del = $_POST["del"];

  if (modifica_preferiti($cat,$mail,$del) == 0)
    header('Location: ../error.php');
  else header('Location: ../gestionePreferiti.php');

  function modifica_preferiti($cat,$mail,$del){
    if(getData("Select * from utente where email='".$mail."'") != 0){
      $resultUtente=getData("Select * from utente where email='".$mail."'");
      $rowUtente=$resultUtente[0];
      $id=$rowUtente["id"];
    }else return 0;


    if($del == 0)
      return setData( "INSERT INTO `categoria_preferita`(`id_utente`, `id_categoria`) VALUES ('".$id."','". $cat."') " );
    else
      return setData( "DELETE FROM `categoria_preferita` WHERE id_categoria = '".$cat."' && id_utente='".$id."'" );

  }

?>
