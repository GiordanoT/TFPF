<?php

    require_once("dbh.inc.php");
    require_once("../test/ScegliDate.php");
    session_start();

    $_SESSION['pagina_visitata'] = 0;

    $durata = $_POST['num_giorni'];
    
    $giorni = array();
    $ora_inizio = array();
    $ora_fine = array();

    array_push($giorni,0);
    array_push($ora_inizio,0);
    array_push($ora_fine,0);

    for($i = 1; $i <= $durata; $i++){
        array_push($giorni,$_POST['data_'.$i]);
        array_push($ora_inizio,$_POST['inizio_'.$i]);
        array_push($ora_fine,$_POST['fine_'.$i]);
    }

    $result = ScegliDate($durata,$giorni,$ora_inizio,$ora_fine);
    
    
    if($result == 0){
        header("Location: ../scegliDate.php?error=bad_data");
        exit();
    }
    if($result == 2){
        header("Location: ../scegliDate.php?error=dbms_error");
        exit();
    }
    else header("Location: ../eventoCreato.php");
    
?>