<?php 
    
    $id_evento = $_GET['id_evento'];
	//----- controllo di sicurezza -------
	$query = "SELECT data,ora_inizio FROM data_evento,evento WHERE id_evento = '{$id_evento}' AND admin_evento = '{$_SESSION['id']}' AND data_evento.id_evento = evento.id";
	$resultDateEvento = getData($query);
	$data_odierna = date("Y-m-d");
	$ora_odierna = date("h:i");
	$sem = 0;
	$date_passate = 0;

	foreach($resultDateEvento as $rowDataEvento){
		$data_limite = date('Y-m-d', strtotime('-1 day', strtotime((string)$rowDataEvento['data'])));
		
		if(($data_odierna < $data_limite) || ($data_odierna == $data_limite && $ora_odierna <= $rowDataEvento['ora_inizio']) )
			$sem = 1;
		else $date_passate++;
	}
	//----- fine controllo -------

    if(isset($_SESSION['id']) && $sem == 1){

        $_SESSION['id_evento'] = $_GET['id_evento'];

        session_start();

        $template = new Template( 'templates/cancellaEvento.template.html' );

        if(isset($_GET['error'])){
            if($_GET['error'] == "bad_data")
                $template -> setContent("Messaggio_errore", "Inserire correttamente i dati");
            else 
                $template -> setContent("Messaggio_errore", "Errore durante l'operazione, riprovare");
        }

        $query = "SELECT evento.nome as nome_evento, data,ora_inizio FROM data_evento,evento WHERE id_evento = '{$_GET['id_evento']}' AND admin_evento = '{$_SESSION['id']}' AND data_evento.id_evento = evento.id";

        $resultDateEvento = getData($query);
        $template -> setContent("NOME_EVENTO", $resultDateEvento[0]["nome_evento"]);
        $data_odierna = date("Y-m-d");

        $ora_odierna = date("h:i");

        $date_passate = 0;

        foreach($resultDateEvento as $rowDataEvento){

            $data_limite = date('Y-m-d', strtotime('-1 day', strtotime((string)$rowDataEvento['data'])));

            if( !( ($data_odierna < $data_limite) || ($data_odierna == $data_limite && $ora_odierna <= $rowDataEvento['ora_inizio'])) )
                $date_passate++;

        }
        
        
        
        $result_durata = getData("SELECT COUNT(id) AS 'durata' FROM data_evento WHERE id_evento = '{$_GET['id_evento']}'");

        $durata = $result_durata[0]['durata'];

        $query = "SELECT data_evento.id as id_data, data,ora_inizio,ora_fine
                  FROM data_evento,evento WHERE id_evento = '{$_GET['id_evento']}' AND admin_evento = '{$_SESSION['id']}' 
                  AND data_evento.id_evento = evento.id ORDER BY data ASC";

        $resultDateEvento = getData($query);
        $date_vecchie = array(); 
        array_push($date_vecchie,0);

        for($i = 1; $i <= $durata; $i++){

            if( $i <= $date_passate ){
                $template -> setContent("FLAG_CESTINO","d-none");
                $template -> setContent("FLAG_CESTINO_DIS","");
                $template -> setContent("DISABLED","disabled");
            }
            else{
                $template -> setContent("FLAG_CESTINO","");
                $template -> setContent("FLAG_CESTINO_DIS","d-none");
            }
            
            $template -> setContent("LINK_CANCELLA_EVENTO", "include/cancellaData.inc.php?id_data={$resultDateEvento[$i-1]['id_data']}");
            $template -> setContent("DATA_ID",$resultDateEvento[$i-1]['id_data']);
            $template -> setContent("value_giorno",$resultDateEvento[$i-1]['data']);
            $template -> setContent("value_inizio",$resultDateEvento[$i-1]['ora_inizio']);
            $template -> setContent("value_fine",$resultDateEvento[$i-1]['ora_fine']);

            $template -> setContent("numero_data",$i);
            $template -> setContent("data", "data_".$i);
            $template -> setContent("inizio", "inizio_".$i);
            $template -> setContent("fine", "fine_".$i);

            array_push($date_vecchie,$resultDateEvento[$i-1]['data']);

        }
        $_SESSION['date_vecchie'] = $date_vecchie;

        if($durata == 1){
            $template -> setContent("singolo_hidden", "hidden");
        }
        else{
            $template -> setContent("singolo_required", "required");
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
