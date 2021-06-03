<?php

    require_once( "dbh.inc.php" );
    require_once("functions/InserimentoCommento.fun.php");
    session_start();

    if( ! isset($_SESSION["id"]) ){
        header('Location: ' .$_SERVER['HTTP_REFERER'].'&login=no');
        exit();
    }
    
    $idutente = $_SESSION["id"];
    $idevento = $_POST["id"];
    $testo = $_POST['message'];
    $testo = addslashes( $testo );
    $testo = strip_tags( $testo );

    $result = InserimentoCommento($idutente, $idevento, $testo);
    if( $result == 1 ){
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }else{
        header('Location: ../error.php ');
        exit();
    }
?>