<?php

    require_once( "dbh.inc.php" );
    session_start();

    if( ! isset($_SESSION["id"]) ){
        header('Location: ' .$_SERVER['HTTP_REFERER'].'&login=no');
        exit();
    }
    
    $idutente = $_SESSION["id"];
    $iddata = $_GET["id"];

    if($_GET["op"]== "agg"){

        $resultData = setData( "INSERT INTO preferito (`id_utente`, `id_data`) VALUES ('{$idutente}','{$iddata}')" );


    }elseif($_GET["op"]== "del"){

        $resultData = setData( "DELETE FROM `preferito` WHERE id_utente ='{$idutente}' and id_data ='{$iddata}'" );

    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>