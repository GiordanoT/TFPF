<?php
	session_start();
	require_once("include/functions/VisualizzazioneEvento.fun.php");

	$template = new Template( 'templates/evento.template.html' );

	function alert($msg) {
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}

	$accesso = $_GET["login"];
	if($accesso == "no")
		alert("Per inserire un evento nei preferiti devi prima accedere");

	$evento=$_GET["id"];
	if( ! is_numeric($evento) ){
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	} else {

		$rowEvento = VisualizzazioneEvento($evento);
		if($rowEvento == 0){
			require( "components/error.component.php" );
			require( "components/footer.component.php" );
			exit();
		}

		if($rowEvento["approvato"] == "0"){
			$template -> setContent( "FLAG_APPROVATO", "" );
			$template -> setContent( "COLORE_APPROVAZIONE", "danger" );
			$template -> setContent( "MESSAGGIO_APPROVAZIONE", "L'Evento non è stato approvato" );
			$template -> setContent("DISABLED_ADMIN", "disabled");

		}elseif($rowEvento["approvato"] == "2"){
			$template -> setContent( "FLAG_APPROVATO", "" );
			$template -> setContent( "COLORE_APPROVAZIONE", "warning" );
			$template -> setContent( "MESSAGGIO_APPROVAZIONE", "L'Evento è in fase di approvazione" );
			$template -> setContent("DISABLED_ADMIN", "disabled");

		}elseif($rowEvento["approvato"] == "1"){
			$template -> setContent( "FLAG_APPROVATO", "d-none" );
			$template -> setContent( "COLORE_APPROVAZIONE", "" );
			$template -> setContent( "MESSAGGIO_APPROVAZIONE", "" );

		}

		if( file_exists($rowEvento['eveimmagine']) ){
			$template -> setContent( "IMMAGINE_EVENTO", $rowEvento['eveimmagine'] );
		} else {
			if( file_exists($rowEvento['catimmagine']) ){
				$template -> setContent( "IMMAGINE_EVENTO",$rowEvento['catimmagine']);
			} else {
				$template -> setContent( "IMMAGINE_EVENTO","image/error.png");
			}
		}
		$template -> setContent("ID_EVENTO", $rowEvento["idevento"]);
		$template -> setContent("TITOLO_EVENTO", $rowEvento["titolo"]);
		$template -> setContent("NOME_CATEGORIA", strtoupper($rowEvento["nomecat"]) );
		$template -> setContent("DESCRIZIONE_EVENTO", $rowEvento["descrizione"]);


		$risultatocontaEvento = getData("SELECT count(*) as conta FROM evento as e JOIN data_evento as de on (e.id = de.id_evento) where e.id = '{$evento}'");
		$rowConta = $risultatocontaEvento[0];
		$conta = $rowConta["conta"];
		$template -> setContent("NUMERO_EVENTI", "{$conta}");
		if( $conta <= 1 ) $template -> setContent("FLAG_TOT", "d-none");

		$risultatodateEvento = getData("SELECT * FROM data_evento d WHERE d.id_evento = '{$evento}' ORDER BY data");
		$i = 0;
		$id= 0;
		foreach($risultatodateEvento as $rowDateEvento){
			$i++;
			$data= $rowDateEvento["data"];

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

			$data= $rowDateEvento["data"];
			$template -> setContent( "ID_DATA", $rowDateEvento['id'] );
			$template -> setContent( "ID", $id);
			$id++;
			$template -> setContent("DATA", $rowDateEvento['data']);
			$template -> setContent("LUOGO_DATA", $rowEvento["citta"]);
			$now = date("Y-m-d");

			$query = "SELECT count(*) as n FROM partecipazione WHERE partecipazione.id_data = {$rowDateEvento['id']}";
			$resultPartecipazioni = getData( $query );
			$postiOccupati = $resultPartecipazioni[0]['n'];
			$postiTotali = $rowEvento['posti'];
			$postiTotali -= $postiOccupati;



			if( $postiTotali < 1 ){
				$template -> setContent("PREZZO", "Non Disponibile");
				$template -> setContent("readonly", "disabled");
				$template -> setContent("hiddenpref", "d-none");
				$template -> setContent("disabled_all", "disabled");
				$template -> setContent("FLAG_TOT", "d-none");
			}
			else{
				if($data >= $now){
					$template -> setContent("N_POSTI", $postiTotali );
					if( $postiTotali == 1 ) $template -> setContent("POSTI_TEXT", "posto" );
					else $template -> setContent("POSTI_TEXT", "posti" );
					$dateDisponibili++;

					$query = "SELECT sconto FROM categoria WHERE id={$rowEvento['e_idc']}";
					$sconto = getData( $query );
					$scontoCategoria = $sconto[0]['sconto'];
					$scontoEvento = $rowEvento['sconto'];
					if( $scontoEvento > $scontoCategoria ) $sconto = $scontoEvento;
					else $sconto = $scontoCategoria;
					if ($sconto == 0) $template -> setContent("SCONTO_FLAG", "d-none");
					else $template -> setContent("SCONTO", $sconto);

					$newPrezzo = ( $rowDateEvento["costo"] * $sconto )/100;
					$newPrezzo = $rowDateEvento["costo"] - $newPrezzo;



					if( $newPrezzo == 0 ){
						$template -> setContent("PREZZO", "GRATIS");
						$template -> setContent("SCONTO_FLAG", "d-none");		
						$template -> setContent("readonly", "");
						$template -> setContent("hiddenpref", "");
					}else{
						$template -> setContent("PREZZO", "{$newPrezzo} €");
						$template -> setContent("readonly", "");
						$template -> setContent("hiddenpref", "");
					}
				}else{
					$template -> setContent("N_POSTI", "0" );
					$template -> setContent("POSTI_TEXT", "posti" );
					$template -> setContent("PREZZO", "Non Disponibile");
					$template -> setContent("readonly", "disabled");
					$template -> setContent("hiddenpref", "d-none");
					$template -> setContent("disabled_all", "disabled");
					$template -> setContent("FLAG_TOT", "d-none");
				}
			}






//BOTTONE PREFERITI


			$resultPref= getData("SELECT * FROM preferito p WHERE p.id_utente={$_SESSION["id"]} AND p.id_data = {$rowDateEvento["id"]}");
			$rowPref = $resultPref[0];

				if( $rowPref == null) {
					$template -> setContent("CUORE", "far fa-heart");
					$template -> setContent("OPERAZIONE", "agg");
				} else {
					$template -> setContent("CUORE", "fas fa-heart");
					$template -> setContent("OPERAZIONE", "del");
				}

//FIN QUA
		}
		if( $i > 1){
			$template -> setContent("FLAG", "");
		} else {
			$template -> setContent("FLAG", "d-none");
		}

// SE L'EVENTO E' VECCHIO DISABILITO I BOTTONI
		$resultFine= getData("SELECT max(data) as fine FROM data_evento where id_evento='{$evento}'");
		$rowFine = $resultFine[0];
		if($rowFine["fine"] < date("Y-m-d"))
			$template -> setContent("disabled", "disabled");

		//COMMENTI
		$resultCommenti = getData("SELECT * FROM commento c JOIN utente u ON (c.id_utente = u.id) WHERE c.id_evento={$evento} ORDER BY data ASC LIMIT 5");
		if(empty($resultCommenti)){
			$template -> setContent("FLAG_C1", "");
			$template -> setContent("FLAG_C", "d-none");
		} else {
			foreach( $resultCommenti as $rowCommenti ){
				$template -> setContent("FLAG_C1", "d-none");
				$template -> setContent("FLAG_C", "");
				$template -> setContent("COMMENTO_AUTORE", $rowCommenti['nome']." ".$rowCommenti['cognome']);
				$template -> setContent("COMMENTO_TESTO",$rowCommenti['testo']);
				$template -> setContent("COMMENTO_DATA",$rowCommenti['data']);
				if( file_exists($rowCommenti['immagine']) ){
					$template -> setContent("IMMAGINE_PROFILO",$rowCommenti['immagine']);
				} else {
					$template -> setContent("IMMAGINE_PROFILO","image/user.png");
				}

			}
		}
		if( isset($_SESSION['id']) ){
			$template -> setContent("FLAG_S","");
			$resultUtente = getData("SELECT * FROM utente u WHERE u.id = {$_SESSION['id']}");
			$rowUtente = $resultUtente[0];
			if( file_exists($rowUtente['immagine']) ){
				$template -> setContent("IMMAGINE_SESSIONE", $rowUtente['immagine']);
			} else {
				$template -> setContent("IMMAGINE_SESSIONE", "image/user.png");
			}
		} else {
			$template -> setContent("FLAG_S", "d-none");
		}


		//EVENTI RECENTI
		$eventi_recenti = getData("SELECT DISTINCT e.id as evento_id, e.citta, e.immagine as immagine_e, e.nome as nome_e, e.posti, e.costo as costo_e, c.nome as nome_c, c.immagine as immagine_c FROM evento e JOIN categoria c ON (c.id = e.id_categoria) JOIN data_evento d ON (d.id_evento = e.id) WHERE e.concluso = 0 AND e.approvato = 1 AND e.id<>'{$evento}' AND d.data > '{$dataOdierna}' ORDER BY d.data DESC LIMIT 10");

		if($eventi_recenti == 0){
			require( "components/error.component.php" );
			require( "components/footer.component.php" );
			exit();
		}
		if(empty($eventi_recenti) ){
			$template -> setContent("FLAG_RECENTI","d-none");
			//EVENTI SCELTI PER L'UTENTE

			if(isset($_SESSION["id"]) ){
				$result_pref = getData( "SELECT c.immagine, c.id FROM categoria_preferita cp JOIN categoria c ON (cp.id_categoria = c.id) JOIN utente u ON (u.id = cp.id_utente) WHERE u.email = '{$_SESSION["mail"]}' " );
				if($result_pref == 0){
					require( "components/error.component.php" );
					require( "components/footer.component.php" );
					exit();
				}
				if(empty($result_pref)){
					$template -> setContent("FLAG_PR","d-none");
				}
				foreach( $result_pref as $row_pref ){
					$result_eventi_pref = getData(" SELECT * FROM evento e WHERE e.id_categoria = {$row_pref["id"]} AND e.concluso=0 AND e.approvato = 1 ORDER BY rand() LIMIT 10 ");
					if($result_eventi_pref == 0){
						require( "components/error.component.php" );
						require( "components/footer.component.php" );
						exit();
					}
					if( empty($result_eventi_pref) ){
						$template -> setContent("FLAG_EVENTI_PR","d-none");
					}
					foreach( $result_eventi_pref as $row_eventi_pref ){
						if( file_exists($row_eventi_pref['immagine']) ){
							$template -> setContent( "EVENTO_IMMAGINE_PREF", $row_eventi_pref['immagine'] );
						} else {
							if( file_exists($row_pref['immagine']) ){
								$template -> setContent( "EVENTO_IMMAGINE_PREF",$row_pref['immagine']);
							} else {
								$template -> setContent( "EVENTO_IMMAGINE_PREF","immagini_categoria/error.png");
							}
						}
						$template -> setContent( "LINK_EVENTO_PREF", "evento.php?id=".$row_eventi_pref['id'] );
						$template -> setContent("EVENTO_NOME_PREF", $row_eventi_pref["nome"]);
						$template -> setContent("EVENTO_CITTA_PREF", $row_eventi_pref["citta"]);


						$prezzoMin = $row_eventi_pref['costo'];


						$result_prezzo = getData("SELECT MIN(costo) as costoMin FROM data_evento WHERE id_evento = {$row_eventi_pref['id']} AND data > '{$dataOdierna}'");
						$row_prezzo = $result_prezzo[0]['costoMin'];

						if($row_prezzo == "0" || $prezzoMin == "0"){
							$template -> setContent( "EVENTO_COSTO_PREF", "GRATIS" );
							$template -> setContent( "VARIABILE_COSTO_PREF", 'style="color: red;"' );
						} else {
							if( $prezzoMin < $row_prezzo){
								$template -> setContent( "VARIABILE_COSTO_PREF", "" );
								$template -> setContent( "EVENTO_COSTO_PREF", "DA: {$prezzoMin} €" );
							} else {
								$template -> setContent( "VARIABILE_COSTO_PREF", "" );
								$template -> setContent( "EVENTO_COSTO_PREF", "DA: {$row_prezzo} €" );
							}

						}

					}

				}
			} else	{
				$template -> setContent("FLAG_PR","d-none");
			}

		} else {
			$template -> setContent("FLAG-PR","d-none");
			foreach( $eventi_recenti as $row_recenti ){


				if( file_exists($row_recenti['immagine_e']) ){
					$template -> setContent( "EVENTO_IMMAGINE_RECENTE", $row_recenti['immagine_e'] );
				} else {
					if( file_exists($row_recenti['immagine_c']) ){
						$template -> setContent( "EVENTO_IMMAGINE_RECENTE",$row_recenti['immagine_c']);
					} else {
						$template -> setContent( "EVENTO_IMMAGINE_RECENTE","immagini_categoria/error.png");
					}
				}
				$template -> setContent("LINK_EVENTO_RECENTE", "evento.php?id=".$row_recenti['evento_id']);
				$template -> setContent("EVENTO_NOME_RECENTE", $row_recenti["nome_e"]);
				$template -> setContent( "CATEGORIA_EVENTO_RECENTE", $row_recenti['nome_c'] );
				$template -> setContent( "EVENTO_CITTA_RECENTE", $row_recenti['citta'] );

				$prezzoMin = $row_recenti['costo_e'];


				$result_prezzo = getData("SELECT MIN(costo) as costoMin FROM data_evento WHERE id_evento = {$row_recenti['evento_id']} AND data > '{$dataOdierna}'");
				$row_prezzo = $result_prezzo[0]['costoMin'];

				if($row_prezzo == "0" || $prezzoMin == "0"){
					$template -> setContent( "EVENTO_COSTO_RECENTE", "GRATIS" );
					$template -> setContent( "VARIABILE_COSTO_RECENTE", 'style="color: red;"' );
				} else {
					if( $prezzoMin < $row_prezzo){
						$template -> setContent( "VARIABILE_COSTO_RECENTE", "" );
						$template -> setContent( "EVENTO_COSTO_RECENTE", "DA: {$prezzoMin} €" );
					} else {
						$template -> setContent( "VARIABILE_COSTO_RECENTE", "" );
						$template -> setContent( "EVENTO_COSTO_RECENTE", "DA: {$row_prezzo} €" );
					}

				}

			}
		}
	}
	if( $dateDisponibili < 1 ){
		$template -> setContent("disabled", "disabled");
	}
	$prezzoTot = ( $rowEvento["prezzo"] * $sconto )/100;
	$prezzoTot = $rowEvento["prezzo"] - $prezzoTot;
	$template -> setContent("PREZZO_TOTALE", $prezzoTot );

	$template -> close();
?>
