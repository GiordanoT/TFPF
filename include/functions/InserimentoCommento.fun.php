<?php

function InserimentoCommento($idutente, $idevento, $testo){
    $now = new DateTime();

    $resultData = setData( "INSERT INTO `commento`(`testo`, `id_evento`, `id_utente`, `data`) VALUES ('{$testo}','{$idevento}','{$idutente}','{$now->format('Y-m-d H:i:s')}')" );

    return  $resultData;
}

?>