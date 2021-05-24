<?php
	$template = new Template( 'templates/evento.template.html' );
	
	$evento=$_GET["id"];

	$risultatoEvento = getData("SELECT e.id_categoria as idcat, e.immagine as eveimmagine, c.immagine as catimmagine, e.nome as titolo, e.citta as citta, e.costo as prezzo,
								e.posti as posti, e.descrizione as descrizione FROM evento as e join categoria as c on (e.id_categoria = c.id ) where e.id ='{$evento}' ");
	$rowEvento = $risultatoEvento[0];
	
	if( file_exists($rowEvento['eveimmagine']) ){
		$template -> setContent( "IMMAGINE_EVENTO", $rowEvento['eveimmagine'] );
	} else {
		if( file_exists($rowEvento['catimmagine']) ){
			$template -> setContent( "IMMAGINE_EVENTO",$rowEvento['catimmagine']);
		} else {
			$template -> setContent( "IMMAGINE_EVENTO","immagini_categoria/error.png");
		}
	}
	$template -> setContent("TITOLO_EVENTO", $rowEvento["titolo"]);

	$risultatoinizioEvento = getData("SELECT de.data as dat FROM evento as e join data_evento as de on (e.id = de.id_evento) where e.id = '{$evento}' order by de.data ASC Limit 1");
	$rowinizioEvento = $risultatoinizioEvento[0];
	$risultatofineEvento = getData("SELECT de.data as dat FROM evento as e join data_evento as de on (e.id = de.id_evento) where e.id = '{$evento}' order by de.data DESC Limit 1");
	$rowfineEvento = $risultatofineEvento[0];
	$dataInizio = $rowinizioEvento["dat"];
	$dataInizio=date("d/m/y",strtotime($dataInizio));
	$dataFine = $rowfineEvento["dat"];
	$dataFine=date("d/m/y",strtotime($dataFine));

	if($dataInizio == $dataFine){
		$template -> setContent("DATA_EVENTO_INIZIO_FINE", "{$dataInizio}");
	}else{
		$template -> setContent("DATA_EVENTO_INIZIO_FINE", "{$dataInizio} - {$dataFine}");
	}
	$risultatocontaEvento = getData("SELECT count(*) as conta FROM evento as e JOIN data_evento as de on (e.id = de.id_evento) where e.id = '{$evento}'");
	$rowConta = $risultatocontaEvento[0];
	$conta = $rowConta["conta"];
	$template -> setContent("NUMERO_EVENTI", "{$conta} data/e");
	$template -> setContent("NUMERO_EVENTI_BARRA", "Ci sono {$conta} data/e:");
	$template -> setContent("DESCRIZIONE_EVENTO", $rowEvento["descrizione"]);

	$risultatodateEvento = getData("SELECT * FROM data_evento WHERE id_evento = '{$evento}'");
	foreach($risultatodateEvento as $rowdateEvento){
		$data= $rowdateEvento["data"];
		$giorno=date("d",strtotime($data));
		$mese=date("m",strtotime($data));
		$anno=date("y",strtotime($data));
		$template -> setContent("GIORNO_DATA", $giorno);
		
		if(!strcmp($mese,"01"))
			$template -> setContent("MESE_DATA", "Gennaio");
		elseif(!strcmp($mese,"02"))
			$template -> setContent("MESE_DATA", "Febbraio");
		elseif(!strcmp($mese,"03"))
			$template -> setContent("MESE_DATA", "Marzo");
		elseif(!strcmp($mese,"04"))
			$template -> setContent("MESE_DATA", "Aprile");
		elseif(!strcmp($mese,"05"))
			$template -> setContent("MESE_DATA", "Maggio");
		elseif(!strcmp($mese,"06"))
			$template -> setContent("MESE_DATA", "Giugno");
		elseif(!strcmp($mese,"07"))
			$template -> setContent("MESE_DATA", "Luglio");
		elseif(!strcmp($mese,"08"))
			$template -> setContent("MESE_DATA", "Agosto");
		elseif(!strcmp($mese,"09"))
			$template -> setContent("MESE_DATA", "Settembre");
		elseif(!strcmp($mese,"10"))
			$template -> setContent("MESE_DATA", "Ottobre");
		elseif(!strcmp($mese,"11"))
			$template -> setContent("MESE_DATA", "Novembre");
		elseif(!strcmp($mese,"12"))
			$template -> setContent("MESE_DATA", "Dicembre");

		$template -> setContent("ANNO_DATA", "20{$anno}");
		$template -> setContent("LUOGO_DATA", $rowEvento["citta"]);
		$template -> setContent("POSTI_DATA", $rowEvento["posti"]);
		if($rowEvento["prezzo"]==0){
			$template -> setContent("PREZZO", "GRATIS");
			$template -> setContent("BOTTONE", "PRENOTATI");
		}else{
			$template -> setContent("PREZZO", "{$rowEvento["prezzo"]} €");
			$template -> setContent("BOTTONE", "ACQUISTA IL BIGLIETTO");
		}
	}

	//EVENTI SIMILI
	$result_simili = getData("SELECT DISTINCT e.citta, e.immagine as immagine_e, e.nome as nome_e, e.posti as posti, e.costo as costo, c.nome as nome_c, c.immagine as immagine_c FROM evento e JOIN data_evento d ON (e.id = d.id_evento) JOIN categoria c ON (c.id = e.id_categoria) 
								where id_categoria = '{$rowEvento["idcat"]}' ORDER BY d.data ASC LIMIT 10");
	if($result_simili == 0){
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	}
	foreach( $result_simili as $row_simili ){
		if( file_exists($row_simili['immagine_e']) ){
			$template -> setContent( "EVENTO_IMMAGINE_SIMILI", $row_simili['immagine_e'] );
		} else {
			if( file_exists($row_simili['immagine_c']) ){
				$template -> setContent( "EVENTO_IMMAGINE_SIMILI",$row_simili['immagine_c']);
			} else {
				$template -> setContent( "EVENTO_IMMAGINE_SIMILI","immagini_categoria/error.png");
			}
		}
		$template -> setContent("EVENTO_NOME_SIMILI", $row_simili["nome_e"]);
		$template -> setContent( "CATEGORIA_EVENTO_SIMILI", $row_simili['nome_c'] );
		$template -> setContent( "EVENTO_CITTA_SIMILI", $row_simili['citta'] );
		$posti = $row_simili['posti'];
		$query = "SELECT count(*) as n FROM partecipazione WHERE id_evento={$row_simili['id']}";
		$resultPartecipazioni = getData( $query );
		$posti -= $resultPartecipazioni[0]['n'];
		$template -> setContent("EVENTO_POSTI_SIMILI", $posti);
		if( isset($row_simili['costo']) && (strcmp($row_simili['costo'],0))){
			$template -> setContent( "EVENTO_COSTO_SIMILI", $row_simili['costo'] );
			$template -> setContent("FLAG_PR", "");
			$template -> setContent("FLAG_PR1", "d-none" );
		} else {
			$template -> setContent("FLAG_PR", "d-none");
			$template -> setContent( "FLAG_PR1", "");
		}
	}
	



	$template -> close();
?>
