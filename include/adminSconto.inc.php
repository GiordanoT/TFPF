<?php

    require_once("dbh.inc.php");
    require_once("../Functions/AdminSconto.php");
    session_start();

    if( !isset($_POST['sconto']) ){
        header("Location: ../adminSconto.php");
        exit();
    }

    $categoria = $_POST['categoria'];
    $sconto = $_POST['percentuale'];
    $result = AdminSconto( $categoria, $sconto );
    if( $result == 1 ){
      header( "Location: ../elencoScontiAdmin.php" ); exit();
    }
    else{
      header( "Location: ../error.php" ); exit();
    }




?>
