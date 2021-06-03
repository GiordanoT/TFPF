<?php

    require_once("dbh.inc.php");
    require_once("functions/scegli_date.fun.php");
    session_start();

    $_SESSION['pagina_visitata'] = 0;

    $durata = $_POST['num_giorni'];

    $prezzo_totale = $_POST['prezzo_totale'];
    
    $giorni = array();
    $ora_inizio = array();
    $ora_fine = array();
    $prezzo_data = array();

    array_push($giorni,0);
    array_push($ora_inizio,0);
    array_push($ora_fine,0);
    array_push($prezzo_data,0);

    for($i = 1; $i <= $durata; $i++){
        array_push($giorni,$_POST['data_'.$i]);
        array_push($ora_inizio,$_POST['inizio_'.$i]);
        array_push($ora_fine,$_POST['fine_'.$i]);

        if($durata > 1)
            array_push($prezzo_data, $_POST['prezzo_'.$i]);
    }


    $result = ScegliDate($durata,$giorni,$ora_inizio,$ora_fine,$prezzo_data, $prezzo_totale);
    
    
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