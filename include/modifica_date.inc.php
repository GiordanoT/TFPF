<?php

    require_once("dbh.inc.php");
    require_once("functions/modifica_evento.fun.php");
    session_start();

    $durata = $_POST['num_giorni'];
    $prezzo_totale = $_POST['prezzo_totale'];
    $evento = $_SESSION['query_evento']; //query per la modifica delle informazioni per l'evento
    $date_vecchie = $_SESSION['date_vecchie']; //date dell'evento prima delle modifiche fatte dall'utente alla form per le date
    $id_evento = $_SESSION['id_evento'];

    //date,orari e prezzi dell'evento nuovi
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
    
    $result = ModificaEvento($id_evento,$evento,$date_vecchie,$durata,$giorni,$ora_inizio,$ora_fine,$prezzo_data, $prezzo_totale);

    if($result == 0){
        header("Location: ../modificaDate.php?error=bad_data");
        exit();
    }
    if($result == 2){
        header("Location: ../modificaDate.php?error=dbms_error");
        exit();
    }
    else header("Location: ../eventoModificato.php");
    
?>