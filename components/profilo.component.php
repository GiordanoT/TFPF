<?php
	$template = new Template( 'templates/profilo.template.html' );
	if( !isset( $_SESSION['mail']) ){
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	}
	$resultUtente = getData("SELECT * FROM utente WHERE id={$_SESSION['id']}");
	$rowUtente = $resultUtente[0];
	$template -> setContent("PROFILO_IMMAGINE", $rowUtente["immagine"]);
    $template -> setContent("nome", $_SESSION['nome']);
    $template -> setContent("cognome", $_SESSION['cognome']);
    $template -> setContent("email", $_SESSION['mail']);

	$resultEventi = getData("SELECT e.citta as citta_e, e.costo as costo_e, c.nome as catnome, e.posti as posti_e, e.descrizione as descrizione_e, e.nome as nome_e, e.immagine as immagine_e FROM evento e JOIN data_evento d ON (d.id_evento = e.id) JOIN partecipazione p ON (p.id_evento = e.id) JOIN categoria c ON (c.id = e.id_categoria) WHERE p.id_utente = ".$_SESSION['id']);
	if( $resultEventi == 0 ){ require( "components/error.component.php" ); require( "components/footer.component.php" ); exit(); } //errore con DB

	if( empty($resultEventi) ){
		$template -> setContent("FLAG_EVENTI","");
		$template -> setContent("FLAG_EVENTI_PRESENTI","d-none");
	} else {
		$template -> setContent("FLAG_EVENTI","d-none");
		$template -> setContent("FLAG_EVENTI_PRESENTI","");

		foreach($resultEventi as $rowEventi){

			$template -> setContent( "TITOLO", $rowEventi["nome_e"]);

			if( file_exists($rowEventi["immagine_e"]) ){
				$template -> setContent( "EVENTO_IMMAGINE", $rowEventi["immagine_e"]);
			}else if(file_exists($rowEventi["immagine_e"])){
				$template -> setContent( "EVENTO_IMMAGINE", $rowEventi["immagine_e"]);
			} else {
				$template -> setContent( "EVENTO_IMMAGINE", "image/error.png");
			}

			$template -> setContent( "DESCRIZIONE", $rowEventi["descrizione_e"]);
			$template -> setContent( "POSTI", $rowEventi["posti_e"]);
			$template -> setContent( "CATEGORIA", $rowEventi["catnome"]);
			$template -> setContent( "LINK", "evento.php?id={$rowEventi['e_id']}");

			if($rowEventi["costo"] != "0"){
				$template -> setContent( "COSTO", "Costo: ".$rowEventi["costo_e"]);
				$template -> setContent( "variabile", "");
			}else{
				$template -> setContent( "COSTO", "GRATIS");
				$template -> setContent( "variabile", "text-danger mt-2");
			}
			$template -> setContent( "CITTA", $rowEventi["citta_e"]);
		}
	}


	$template -> close();
?>
