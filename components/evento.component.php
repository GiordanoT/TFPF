<?php
	session_start();

	$template = new Template( 'templates/evento.template.html' );
	
	function alert($msg) {
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}

	if($_GET["login"]=="no")
		alert("Per inserire un evento nei preferiti devi prima accedere");

	$evento=$_GET["id"];
	if( ! is_numeric($evento) ){
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	} else {

		$risultatoEvento = getData("SELECT e.id as idevento, e.id_categoria as idcat, e.immagine as eveimmagine, c.immagine as catimmagine, e.nome as titolo, e.citta as citta, e.costo as prezzo,
		e.posti as posti, e.descrizione as descrizione, c.nome as nomecat FROM evento as e join categoria as c on (e.id_categoria = c.id ) where e.id ='{$evento}' ");
		$rowEvento = $risultatoEvento[0];

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

		$risultatodateEvento = getData("SELECT * FROM data_evento d WHERE d.id_evento = '{$evento}'");
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
			if($rowEvento["prezzo"]==0){
				$template -> setContent("PREZZO", "GRATIS");
			}else{
				$template -> setContent("PREZZO", "{$rowEvento["prezzo"]} €");
			}
	

//QUESTO PER IL BOTTONE DEI PREFERITI MA LO DEVI MODIFICARE


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

		$result_recenti = getData("SELECT DISTINCT e.id as evento_id, e.citta, e.immagine as immagine_e, e.nome as nome_e, e.posti, e.costo, c.nome as nome_c, c.immagine as immagine_c FROM evento e JOIN data_evento d ON (e.id = d.id_evento) JOIN categoria c ON (c.id = e.id_categoria) WHERE e.concluso=0 AND e.id<>{$evento} ORDER BY d.data ASC LIMIT 10");
	
		if($result_recenti == 0){
			require( "components/error.component.php" );
			require( "components/footer.component.php" );
			exit();
		}
		if( empty($result_recenti) ){
			$template -> setContent("FLAG_RECENTI","d-none");
		}
		foreach( $result_recenti as $row_recenti ){
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
			$posti = $row_recenti['posti'];
			$query = "SELECT count(*) as n FROM partecipazione WHERE id_evento={$row_recenti['id']}";
			$resultPartecipazioni = getData( $query );
			$posti -= $resultPartecipazioni[0]['n'];
			$template -> setContent("EVENTO_POSTI_RECENTE", $posti);
			if( isset($row_recenti['costo']) && (strcmp($row_recenti['costo'],0))){
				$template -> setContent( "EVENTO_COSTO_RECENTE", $row_recenti['costo'] );
				$template -> setContent("FLAG_RE", "");
				$template -> setContent("FLAG_RE1", "d-none" );
			} else {
				$template -> setContent("FLAG_RE", "d-none");
				$template -> setContent( "FLAG_RE1", "");
			}
		}


		//EVENTI SIMILI
		$result_simili = getData("SELECT DISTINCT e.id as evento_id, e.citta, e.immagine as immagine_e, e.nome as nome_e, e.posti as posti, e.costo as costo, c.nome as nome_c, c.immagine as immagine_c FROM evento e JOIN data_evento d ON (e.id = d.id_evento) JOIN categoria c ON (c.id = e.id_categoria) where e.id_categoria = '{$rowEvento["idcat"]}' AND e.id<>{$evento} ORDER BY d.data ASC LIMIT 10");
		if( empty($result_simili) ){
			//SE NON CI SONO EVENTI SIMILI
			$template -> setContent("FLAG_SIMILI","d-none");
			if(isset($_SESSION["id"]) ){
				//SE HA FATTO L'ACCESSO FA VEDERE GLI EVENTI CONSIGLIATI
				$result_pref = getData( "SELECT c.immagine, c.id FROM categoria_preferita cp JOIN categoria c ON (cp.id_categoria = c.id) JOIN utente u ON (u.id = cp.id_utente) WHERE u.email = '{$_SESSION["mail"]}' " );
				if($result_pref == 0){
					require( "components/error.component.php" );
					require( "components/footer.component.php" );
					exit();
				}
				if(empty($result_pref)){
					$template -> setContent("FLAG-PR","d-none");
					$template -> setContent("FLAG_RECENTI","");
				} else {
					$template -> setContent("FLAG_RECENTI","d-none");
					$template -> setContent("FLAG-PR","");

					foreach( $result_pref as $row_pref ){
						$result_eventi = getData(" SELECT * FROM evento e WHERE e.id_categoria = {$row_pref["id"]} AND e.concluso=0 AND e.id<>{$evento} ORDER BY rand() LIMIT 3 ");
						if($result_eventi == 0){
							require( "components/error.component.php" );
							require( "components/footer.component.php" );
							exit();
						}
						foreach( $result_eventi as $row_eventi_pref ){
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
			
							$posti = $row_eventi_pref['posti'];
							$query = "SELECT count(*) as n FROM partecipazione WHERE id_evento={$row_eventi_pref['id']}";
							$resultPartecipazioni = getData( $query );
							if($resultPartecipazioni == 0){
								require( "components/error.component.php" );
								require( "components/footer.component.php" );
								exit(); 
							}
							$posti -= $resultPartecipazioni[0]['n'];
							$template -> setContent("EVENTO_POSTI_PREF", $posti);
							if( isset($row_eventi_pref['costo']) && (strcmp($row_eventi_pref['costo'],0))){
								$template -> setContent( "EVENTO_COSTO_PREF", $row_eventi_pref['costo'] );
								$template -> setContent("FLAG_PR", " ");
								$template -> setContent("FLAG_PR1", "d-none" );
							} else {
								$template -> setContent("FLAG_PR", "d-none");
								$template -> setContent( "FLAG_PR1", " ");
							}
						}
					}
				}
				
			} else {
				$template -> setContent("FLAG-PR","d-none");
				$template -> setContent("FLAG_RECENTI","");
			}
		} else {
			$template -> setContent("FLAG-PR","d-none");
			$template -> setContent("FLAG_RECENTI","d-none");
			foreach( $result_simili as $row_simili ){
				if( file_exists($row_simili['immagine_e']) ){
					$template -> setContent( "EVENTO_IMMAGINE_SIMILI", $row_simili['immagine_e'] );
				} else {
					if( file_exists($row_simili['immagine_c']) ){
						$template -> setContent( "EVENTO_IMMAGINE_SIMILI",$row_simili['immagine_c']);
					} else {
						$template -> setContent( "EVENTO_IMMAGINE_SIMILI","images/error.png");
					}
				}
				$template -> setContent("LINK_EVENTO_SIMILI", "evento.php?id=".$row_simili['evento_id']);
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
					$template -> setContent("FLAG_R", "");
					$template -> setContent("FLAG_R1", "d-none" );
				} else {
					$template -> setContent("FLAG_R", "d-none");
					$template -> setContent( "FLAG_R1", "");
				}
			}
		
		}
	}

	$template -> close();
?>
