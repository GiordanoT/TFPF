<?php
  require_once( "dbh.inc.php" );
  session_start();

  if(getData( "SELECT ruolo FROM utente where email='{$_SESSION['mail']}' AND ruolo='0'")){
    setData("UPDATE `utente` SET ruolo='1' WHERE email='{$_SESSION['mail']}'");
    header('Location:../home.php?popup=true');
    exit();
  }else{
    setData("UPDATE `utente` SET ruolo='0' WHERE email='{$_SESSION['mail']}'");
    header('Location:../home.php?popup=false');
    exit();
  }

?>
