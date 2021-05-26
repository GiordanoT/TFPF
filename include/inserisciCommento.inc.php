<?php

    require_once( "dbh.inc.php" );
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

    $now = new DateTime();

    $resultData = setData( "INSERT INTO `commento`(`testo`, `id_evento`, `id_utente`, `data`) VALUES ('{$testo}','{$idevento}','{$idutente}','{$now->format('Y-m-d H:i:s')}')" );

    echo $resultData;

    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>