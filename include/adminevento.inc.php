<?php
  require_once( "dbh.inc.php" );
  session_start();

  if( $_SESSION['admin'] == 0 ){
    $_SESSION['admin'] = 1;
    header('Location:../home.php?popup=true');
    //header('Location:../home.php');
    exit();
  }else{
    $_SESSION['admin'] = 0;
    header('Location:../home.php?popup=false');
    //header('Location:../home.php');
    exit();
  }

?>
