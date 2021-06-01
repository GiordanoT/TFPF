<?php

	require_once('include/dbh.inc.php');
	session_start();

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
		
		$template = new Template( 'templates/modificaEvento.template.html' );

		$_SESSION['id_evento'] = $_GET['id_evento'];
		$_SESSION['date_passate'] = $date_passate;

		if( isset($_GET['error'])){
			if($_GET['error'] == "bad_data")
				$template -> setContent("Messaggio_errore", "Inserire correttamente i dati");
			else 
				$template -> setContent("Messaggio_errore", "Errore durante l'operazione, riprovare");
		}

		$template -> setContent("link_modifica", "include/modifica_evento.inc.php");

        $result_evento = getData("SELECT * from evento where id = '{$_GET['id_evento']}'");
        $evento = $result_evento[0];

        $template -> setContent("nome", $evento['nome']);
        $template -> setContent("descrizione", $evento['descrizione']);

        if($evento['tipologia'] == 0){
            $template -> setContent("selected_tipologia_0", "selected");
        }
        else  $template -> setContent("selected_tipologia_1", "selected");

		$result_categorie = getData("SELECT id,nome FROM categoria");
		foreach($result_categorie as $row_categoria){
			$template -> setContent("categoria_value", $row_categoria['id']);
			$template -> setContent("categoria", $row_categoria['nome']);
            if($row_categoria['id'] == $evento['id_categoria'])
                $template -> setContent("selected_categoria", "selected");
		}

		$result_durata = getData("SELECT COUNT(id) AS 'durata' FROM data_evento WHERE id_evento = '{$_GET['id_evento']}'");
        $durata = $result_durata[0]['durata'];
		
		for($i = $durata; $i <= 7; $i++){
			$template -> setContent("giorno_value", $i);
			if($i == 1)
				$template -> setContent("giorno", $i." giorno");
			else 
				$template -> setContent("giorno", $i." giorni");
			if($i == $durata)
				$template -> setContent("selected_giorno", "selected");
		}

        $template -> setContent("citta", $evento['citta']);
        $template -> setContent("posti", $evento['posti']);

		$template -> close();
	}
	else {
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	}
?>
