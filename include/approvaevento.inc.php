<?php

    require_once("dbh.inc.php");
    require_once("functions/ApprovaEvento.fun.php");
    session_start();

    $id = $_GET['id'];
    $del = $_GET['del'];
    $result = ApprovaEvento( $id, $del );

    if( $result == 1 ){
      header( "Location: ../approvaevento.php" );
      exit();
    }
    else{
      header( "Location: ../error.php" ); 
      exit();
    }




?>