<?php
	error_reporting(E_ALL ^ (E_WARNING | E_NOTICE));
	$template = new Template( 'templates/eventicreati.template.html' );
	session_start();

	$resultEventiCreati = getData("SELECT e.nome as nome, e.descrizione as descrizione, c.nome as catnome, e.tipologia, e.posti as posti, e.costo as costo, e.immagine, e.citta as citta, c.immagine 
									FROM evento as e JOIN utente as u on(u.id = e.admin_evento ) JOIN categoria as c on(e.id_categoria = c.id) where u.email = '{$_SESSION['mail']}'");
	
	if($resultEventiCreati == 0){
		$template -> setContent( "hidden", "" );
	}else{
		$template -> setContent( "hidden", "hidden" );
		foreach($resultEventiCreati as $rowEventiCreati){

			$template -> setContent( "TITOLO", $rowEventiCreati["nome"]);
			if(file_exists($rowEventiCreati["e.immagine"])){
				$template -> setContent( "EVENTO_IMMAGINE", $rowEventiCreati["e.immagine"]);
			}else if(file_exists($rowEventiCreati["c.immagine"])){
				$template -> setContent( "EVENTO_IMMAGINE", $rowEventiCreati["c.immagine"]);
			}else
				$template -> setContent( "EVENTO_IMMAGINE", "immagini_categoria/error.png");

	$template -> setContent( "DESCRIZIONE", $rowEventiCreati["descrizione"]);
	$template -> setContent( "POSTI", $rowEventiCreati["posti"]);
	$template -> setContent( "CATEGORIA", $rowEventiCreati["catnome"]);

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
