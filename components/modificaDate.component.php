<?php

    if(isset($_SESSION['id'])){

        session_start();

        $template = new Template( 'templates/modificaDate.template.html' );

        $durata = (int)$_SESSION['durata'];

        if(isset($_GET['error'])){
            if($_GET['error'] == "bad_data")
                $template -> setContent("Messaggio_errore", "Inserire correttamente i dati");
            else 
                $template -> setContent("Messaggio_errore", "Errore durante l'operazione, riprovare");
        }

        $query = "SELECT data,ora_inizio,ora_fine,data_evento.costo AS costo_singolo, evento.costo AS costo_totale 
                  FROM data_evento,evento WHERE id_evento = '{$_SESSION['id_evento']}' AND admin_evento = '{$_SESSION['id']}' 
                  AND data_evento.id_evento = evento.id ORDER BY data ASC";

        $resultDateEvento = getData($query);
        $date_vecchie = array(); 
        array_push($date_vecchie,0);

        for($i = 1; $i <= $durata; $i++){

            if($i <= $_SESSION['date_passate']){
                $template -> setContent("readonly","readonly");
            }

            $template -> setContent("value_giorno",$resultDateEvento[$i-1]['data']);
            $template -> setContent("value_inizio",$resultDateEvento[$i-1]['ora_inizio']);
            $template -> setContent("value_fine",$resultDateEvento[$i-1]['ora_fine']);
            $template -> setContent("value_prezzo",$resultDateEvento[$i-1]['costo_singolo']);

            $template -> setContent("numero_data",$i);
            $template -> setContent("data", "data_".$i);
            $template -> setContent("inizio", "inizio_".$i);
            $template -> setContent("fine", "fine_".$i);
            $template -> setContent("prezzo", "prezzo_".$i);

            array_push($date_vecchie,$resultDateEvento[$i-1]['data']);

        }
        $_SESSION['date_vecchie'] = $date_vecchie;

        if($_SESSION['date_passate'] > 0){
            $template -> setContent("totale_readonly", "readonly"); 
        }

        if($durata == 1){
            $template -> setContent("singolo_hidden", "hidden");
            $template -> setContent("label_prezzo", "Prezzo del biglietto (€):");
            $template -> setContent("prezzo_totale",$resultDateEvento[0]['costo_totale']);
        }
        else{
            $template -> setContent("singolo_required", "required");
            $template -> setContent("label_prezzo", "Prezzo del pacchetto completo (€):");
            $template -> setContent("prezzo_totale",$resultDateEvento[0]['costo_totale']);
        }
        
        $template -> setContent("num_giorni", $durata);

        $template -> close();
    }
    else {
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	}
?>
