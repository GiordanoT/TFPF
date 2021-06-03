<?php

    require_once("dbh.inc.php");
    require_once("functions/UtenteSconto.fun.php");
    session_start();

    if( !isset($_POST['sconto']) ){
        header("Location: ../utenteSconto.php");
        exit();
    }

    $evento = $_POST['evento'];
    $sconto = $_POST['percentuale'];
    $result = UtenteSconto( $evento, $sconto );
    if( $result == 1 ){
      header( "Location: ../elencoScontiUtente.php" ); exit();
    }
    else{
      header( "Location: ../error.php" ); exit();
    }




?>
