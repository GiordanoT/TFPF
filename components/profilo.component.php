<?php
	$template = new Template( 'templates/profilo.template.html' );
	if( !isset( $_SESSION['mail']) ){
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	}
	$resultUtente = getData("SELECT * FROM utente WHERE id={$_SESSION['id']}");
	$rowUtente = $resultUtente[0];
    $template -> setContent("nome", $_SESSION['nome']);
    $template -> setContent("cognome", $_SESSION['cognome']);
    $template -> setContent("email", $_SESSION['mail']);

	//STORICO EVENTI

	$resultEventi = getData("SELECT p.codice as id_d, d.data as data_e, e.citta as citta_e, e.costo as costo_e, c.nome as catnome, e.posti as posti_e, e.descrizione as descrizione_e, e.nome as nome_e, e.immagine as immagine_e, d.ora_inizio as ora_inizio, d.ora_fine as ora_fine FROM evento e JOIN data_evento d ON (d.id_evento = e.id) JOIN partecipazione p ON (p.id_data = d.id) JOIN categoria c ON (c.id = e.id_categoria) WHERE p.id_utente = ".$_SESSION['id']." ORDER BY e.id");
	if( !isset($_POST['previous']) && !isset($_POST['next']) ) {
		$template -> setContent( "ID_RICERCA", 0 );
		$template -> setContent( "FLAG_PREVIOUS", "d-none" );
		$indicePagina = 0;
	}
	else{
		$indicePagina = $_POST['indice'];
	}

	if( $resultEventi == 0 ){ require( "components/error.component.php" ); require( "components/footer.component.php" ); exit(); } //errore con DB
	if( isset($_POST['previous'])) { $template -> setContent( "ID_RICERCA", $_POST['indice']-9 ); $indicePagina -= 9; }
	if( isset($_POST['next'])) { $template -> setContent( "ID_RICERCA", $_POST['indice']+9 ); $indicePagina += 9; }
	if( $indicePagina == 0 ){ $template -> setContent( "FLAG_PREVIOUS", "d-none" ); }

	if( empty($resultEventi) ){
		$template -> setContent("FLAG_EVENTI","");
		$template -> setContent( "FLAG_PREVIOUS", "d-none" );
		$template -> setContent( "FLAG_NEXT", "d-none" );
		$template -> setContent("FLAG_EVENTI_PRESENTI","d-none");
	} else {
		$template -> setContent("FLAG_EVENTI","d-none");
		$template -> setContent("FLAG_EVENTI_PRESENTI","");

		$i = 0;
		while( $i < 9 AND isset($resultEventi[$indicePagina]) ){

			$template -> setContent( "TITOLO", $resultEventi[$indicePagina]["nome_e"]);
			$template -> setContent("DATA_EVENTO",$resultEventi[$indicePagina]['data_e']);
			$template -> setContent("ID_DATA_EVENTO",$resultEventi[$indicePagina]['id_d']);
			
			$inizio = $resultEventi[$indicePagina]['ora_inizio'];
			$oraInizio = substr($inizio, 0, 5);

			$fine = $resultEventi[$indicePagina]['ora_fine'];
			$oraFine = substr($fine, 0, 5);

			$template -> setContent("ORA_INIZIO_EVENTO",$oraInizio);
			$template -> setContent("ORA_FINE_EVENTO",$oraFine);

			if( file_exists($resultEventi[$indicePagina]["immagine_e"]) ){
				$template -> setContent( "EVENTO_IMMAGINE", $resultEventi[$indicePagina]["immagine_e"]);
			}else if(file_exists($resultEventi[$indicePagina]["immagine_e"])){
				$template -> setContent( "EVENTO_IMMAGINE", $resultEventi[$indicePagina]["immagine_e"]);
			} else {
				$template -> setContent( "EVENTO_IMMAGINE", "image/error.png");
			}

			$template -> setContent( "DESCRIZIONE", $resultEventi[$indicePagina]["descrizione_e"]);
			$template -> setContent( "POSTI", $resultEventi[$indicePagina]["posti_e"]);
			$template -> setContent( "CATEGORIA", $resultEventi[$indicePagina]["catnome"]);
			$template -> setContent( "LINK", "evento.php?id={$resultEventi[$indicePagina]['e_id']}");
			$template -> setContent( "CITTA", $resultEventi[$indicePagina]["citta_e"]);
			$i++;
			$indicePagina++;
		}
		if( $indicePagina >= count( $resultEventi ) ){ $template -> setContent( "FLAG_NEXT", "d-none" ); }
	}

	$resultCommenti = getData("SELECT e.id as id_e, e.nome as nome_e, c.data as data_c, c.testo as testo_c, e.immagine as immagine_e, cat.immagine as immagine_cat 
								FROM commento c JOIN evento e ON (e.id = c.id_evento) JOIN categoria cat ON (cat.id = e.id_categoria) 
								WHERE c.id_utente = {$_SESSION['id']}");
	if($resultCommenti == 0){ "components/error.component.php"; require( "components/footer.component.php" ); exit(); }
	if(empty($resultCommenti)){
		$template -> setContent("FLAG_COMMENTI","");
		$template -> setContent("FLAG_COMMENTI_PRESENTI","d-none");
	} else {
		$template -> setContent("FLAG_COMMENTI","d-none");
		$template -> setContent("FLAG_COMMENTI_PRESENTI","");
		foreach($resultCommenti as $rowCommenti){

			$template -> setContent("NOME_EVENTO",$rowCommenti['nome_e']);
			$template -> setContent("LINK_EVENTO", "evento.php?id={$rowCommenti['id_e']}");
			$template -> setContent("DATA_COMMENTO",$rowCommenti['data_c']);
			$template -> setContent("TESTO_COMMENTO",$rowCommenti['testo_c']);

			if( file_exists($rowCommenti['immagine_e']) ){
				$template -> setContent("IMMAGINE_EVENTO",$rowCommenti['immagine_e']);
			} else {
				if( file_exists($rowCommenti['immagine_cat']) ){
					$template -> setContent("IMMAGINE_EVENTO",$rowCommenti['immagine_cat']);
				} else {
					$template -> setContent("IMMAGINE_EVENTO","image/error.png");	
				}

			}
		}
	}
	$template -> close();
?>
