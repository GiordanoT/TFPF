<?php
	error_reporting(E_ALL ^ (E_WARNING | E_NOTICE));
	$template = new Template( 'templates/eventicreati.template.html' );
	session_start();

	$resultEventiCreati = getData("SELECT e.id as e_id, e.nome as nome, e.descrizione as descrizione, c.nome as catnome, e.tipologia, e.posti as posti, e.costo as costo, e.immagine as e_immagine, e.citta as citta, c.immagine as c_immagine
									FROM evento as e JOIN utente as u on(u.id = e.admin_evento ) JOIN categoria as c on(e.id_categoria = c.id) where u.email = '{$_SESSION['mail']}'");

	if(!($resultEventiCreati)){
		$template -> setContent( "hidden", "" );
		$template -> setContent( "flag", "d-none" );

	}else{
		$template -> setContent( "hidden", "d-none" );
		foreach($resultEventiCreati as $rowEventiCreati){

			$template -> setContent( "TITOLO", $rowEventiCreati["nome"]);

			$query = "SELECT data,ora_inizio FROM data_evento,evento WHERE id_evento = '{$rowEventiCreati['e_id']}' AND admin_evento = '{$_SESSION['id']}' AND data_evento.id_evento = evento.id";
			$resultDateEvento = getData($query);
			$data_odierna = date("Y-m-d");
			$ora_odierna = date("h:i");
			$sem = 0;

			foreach($resultDateEvento as $rowDataEvento){
				$data_limite = date('Y-m-d', strtotime('-1 day', strtotime((string)$rowDataEvento['data'])));
				
				if($data_odierna < $data_limite && $ora_odierna <= $rowDataEvento['ora_inizio'] )
					$sem = 1;
			}

			if($sem == 0){
				$template -> setContent("hidden_modifica","d-none");
			}
			else{
				$template -> setContent("LINK_MODIFICA_EVENTO","modificaEvento.php?id_evento=".$rowEventiCreati['e_id']);
				$template -> setContent("hidden_modifica","");
			}

			if( file_exists($rowEventiCreati["e_immagine"]) ){
				$template -> setContent( "EVENTO_IMMAGINE", $rowEventiCreati["e_immagine"]);
			}else if(file_exists($rowEventiCreati["c_immagine"])){
				$template -> setContent( "EVENTO_IMMAGINE", $rowEventiCreati["c_immagine"]);
			}else
				$template -> setContent( "EVENTO_IMMAGINE", "image/error.png");

			$template -> setContent( "DESCRIZIONE", $rowEventiCreati["descrizione"]);
			$template -> setContent( "POSTI", $rowEventiCreati["posti"]);
			$template -> setContent( "CATEGORIA", $rowEventiCreati["catnome"]);
			$template -> setContent( "LINK", "evento.php?id={$rowEventiCreati['e_id']}");

			if($rowEventiCreati["costo"] != "0"){
				$template -> setContent( "COSTO", "Costo: ".$rowEventiCreati["costo"]);
				$template -> setContent( "variabile", "");
			}else{
				$template -> setContent( "COSTO", "GRATIS");
				$template -> setContent( "variabile", "text-danger mt-2");
			}
			$template -> setContent( "CITTA", $rowEventiCreati["citta"]);
		}
	}

	$template -> close();
?>
