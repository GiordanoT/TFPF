<?php
  session_start();
  require_once( "dbh.inc.php" );
  require_once( "../test/categoriaPreferita.php" );

  if( !isset($_POST['preferiti']) ){
    header("Location: ../gestionePreferiti.php");
    exit();
  }

  $cat = $_POST["cat"];
  $mail= $_SESSION["mail"];
  $del = $_POST["del"];

  if (modifica_preferiti($cat,$mail,$del) == 0){
    header('Location: ../error.php');
    exit();
  }
  else {
    header('Location: ../gestionePreferiti.php');
    exit();
}


?>
