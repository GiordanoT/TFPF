<?php

    require_once("dbh.inc.php");
    require_once("functions/DeletePartecipazione.fun.php");  
    session_start();

    $id = $_GET["id"];

    $result = DeletePartecipazione($id);
    if($result == 1){
        header("Location: ../eventiutente.php?id={$_SESSION["id"]}");
        exit();
    }else{
        header("Location: ../error.php");
        exit();
    }
?>