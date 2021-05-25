<?php

    require_once("dbh.inc.php");
    require_once("../Functions/UtenteSconto.php");
    session_start();

    if( !isset($_POST['sconto']) ){
        header("Location: ../utenteSconto.php");
        exit();
    }

    $evento = $_GET['id'];
    $result = UtenteSconto( $evento, 0 );
    if( $result == 1 ){
      header( "Location: ../elencoScontiUtente.php" ); exit();
    }
    else{
      header( "Location: ../error.php" ); exit();
    }




?>
