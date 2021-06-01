<?php
	error_reporting(E_ALL ^ (E_WARNING | E_NOTICE));
	$template = new Template( 'templates/eventicreati.template.html' );
	session_start();

	$resultEventiCreati = getData("SELECT e.id as e_id, e.nome as nome, e.descrizione as descrizione, c.nome as catnome, e.tipologia, e.posti as posti, e.costo as costo, e.immagine as e_immagine, e.citta as citta, c.immagine as c_immagine
									FROM evento as e JOIN utente as u on(u.id = e.admin_evento ) JOIN categoria as c on(e.id_categoria = c.id) where u.email = '{$_SESSION['mail']}'");

	if(!($resultEventiCreati)){
		$template -> setContent( "hidden", "" );
		$template -> setContent( "flag", "d-none" );
		 $template -> setContent( "FLAG_NEXT", "d-none" );
		  $template -> setContent( "FLAG_PREVIOUS", "d-none" );

	}else{
		$template -> setContent( "hidden", "d-none" );
		if( !isset($_POST['previous']) && !isset($_POST['next']) ) {
			$template -> setContent( "ID_RICERCA", 0 );
			$template -> setContent( "FLAG_PREVIOUS", "d-none" );
			$indicePagina = 0;
		}
		else{
			$indicePagina = $_POST['indice'];
		}
		if( isset($_POST['previous'])) { $template -> setContent( "ID_RICERCA", $_POST['indice']-9 ); $indicePagina -= 9; }
		if( isset($_POST['next'])) { $template -> setContent( "ID_RICERCA", $_POST['indice']+9 ); $indicePagina += 9; }
		if( $indicePagina == 0 ){ $template -> setContent( "FLAG_PREVIOUS", "d-none" ); }
		$i = 0;
		while( $i < 9 && isset( $resultEventiCreati[$indicePagina] ) ){
				$template -> setContent( "TITOLO", $resultEventiCreati[$indicePagina]["nome"]);

				$query = "SELECT d.data as data, d.ora_inizio as ora_inizio, d.costo as costo_data FROM data_evento d ,evento e WHERE d.id_evento = '{$resultEventiCreati[$indicePagina]['e_id']}' AND admin_evento = '{$_SESSION['id']}' AND d.id_evento = e.id";
				$resultDateEvento = getData($query);
				$data_odierna = date("Y-m-d");
				date_default_timezone_set('Europe/Rome');
				$ora_odierna = date("h:i");
				$sem = 0;
				$prezzoMin = 0;
				$prezzoMax = 0;


				foreach($resultDateEvento as $rowDataEvento){

					if($rowDataEvento['costo_data'] > $prezzoMax ){ $prezzoMax =  $rowDataEvento['costo_data']; }
					if($rowDataEvento['costo_data'] < $prezzoMin ){ $prezzoMin =  $rowDataEvento['costo_data']; }

					$data_limite = date('Y-m-d', strtotime('-1 day', strtotime((string)$rowDataEvento['data'])));

					if(($data_odierna < $data_limite) || ($data_odierna == $data_limite && $ora_odierna < $rowDataEvento['ora_inizio']) )
						$sem = 1;
				}
				

				if($sem == 0){
					$template -> setContent("hidden_modifica","d-none");
				}
				else{
					$template -> setContent("LINK_MODIFICA_EVENTO","modificaEvento.php?id_evento=".$resultEventiCreati[$indicePagina]['e_id']);
					$template -> setContent("LINK_CANCELLA_EVENTO","cancellaEvento.php?id_evento=".$resultEventiCreati[$indicePagina]['e_id']);
					$template -> setContent("hidden_modifica","");
				}

				if( file_exists($resultEventiCreati[$indicePagina]["e_immagine"]) ){
					$template -> setContent( "EVENTO_IMMAGINE", $resultEventiCreati[$indicePagina]["e_immagine"]);
				}else if(file_exists($resultEventiCreati[$indicePagina]["c_immagine"])){
					$template -> setContent( "EVENTO_IMMAGINE", $resultEventiCreati[$indicePagina]["c_immagine"]);
				}else
					$template -> setContent( "EVENTO_IMMAGINE", "image/error.png");

				$template -> setContent( "DESCRIZIONE", $resultEventiCreati[$indicePagina]["descrizione"]);
				$template -> setContent( "POSTI", $resultEventiCreati[$indicePagina]["posti"]);
				$template -> setContent( "CATEGORIA", $resultEventiCreati[$indicePagina]["catnome"]);
				$template -> setContent( "LINK", "evento.php?id={$resultEventiCreati[$indicePagina]['e_id']}");

				if($resultEventiCreati[$indicePagina]["costo"] != "0"){
					
					if($prezzoMin == $prezzoMax){
						$template -> setContent("COSTO1", "$prezzoMax");
						$template -> setContent("COSTO2", "");
					} else {
						$template -> setContent("COSTO1", "$prezzoMin");
						$template -> setContent("COSTO2", "- {$prezzoMax} €");
					}

					$template -> setContent( "COSTO", "Costo: ".$resultEventiCreati[$indicePagina]["costo"]);
					$template -> setContent( "FLAG_COSTO_D", "d-none");
					$template -> setContent( "FLAG_COSTO_T", "");
					$template -> setContent( "variabile", "");
				}else{
					$template -> setContent( "COSTO", "GRATIS");
					$template -> setContent( "variabile", "text-danger mt-2");
				}
				$template -> setContent( "CITTA", $resultEventiCreati[$indicePagina]["citta"]);
				$i++;
				$indicePagina++;
			}
			if( $indicePagina >= count( $resultEventiCreati ) ){ $template -> setContent( "FLAG_NEXT", "d-none" );  }
		}
	$template -> close();
?>
