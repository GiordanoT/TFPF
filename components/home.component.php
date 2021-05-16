<?php
  error_reporting(E_ALL ^ (E_WARNING | E_NOTICE));

	require_once('include\dbh.inc.php');
	$template = new Template( 'templates/home.template.html' );
	$template -> setContent( "IMMAGINE_CAROUSEL","immagini_categoria/carousel.jpg" );

	$result_recenti = getData("SELECT DISTINCT e.immagine as immagine_e, e.nome as nome_e, e.posti, e.costo, c.nome as nome_c, c.immagine as immagine_c FROM evento e JOIN data_evento d ON (e.id = d.id_evento) JOIN categoria c ON (c.id = e.id_categoria) ORDER BY d.data ASC LIMIT 10");
	if($result_recenti == 0){
	 //mettere errore	
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
		$template -> setContent("EVENTO_NOME_RECENTE", $row_recenti["nome_e"]);
		$posti = $row_recenti['posti'];
		$query = "SELECT count(*) as n FROM partecipazione WHERE id_evento={$row_recenti['id']}";
		$resultPartecipazioni = getData( $query );
		if($resultPartecipazioni == 0){
			//mettere errore	
		}
		$posti -= $resultPartecipazioni[0]['n'];
		$template -> setContent("EVENTO_POSTI_RECENTE", $posti);
		if( isset($row_recenti['costo']) && (strcmp($row_recenti['costo'],0))){
			$template -> setContent( "EVENTO_COSTO_RECENTE", $row_recenti['costo'] );
			$template -> setContent("FLAG_R", "");
			$template -> setContent("FLAG_R1", "d-none" );
		} else {
			$template -> setContent("FLAG_R", "d-none");
			$template -> setContent( "FLAG_R1", "");
		}
	}
	
	
	$result = getData("SELECT * FROM categoria ORDER BY nome LIMIT 3");
	if($result == 0){
		//mettere errore	
	}
	foreach( $result as $row ){
		$template -> setContent( "CATEGORIA", strtoupper($row['nome']) );
		if( file_exists($row['immagine']) ){
			$template -> setContent( "CATEGORIA_IMMAGINE", $row['immagine'] );	
		} else {
			$template -> setContent( "CATEGORIA_IMMAGINE","immagini_categoria/error.png");
		}

		$result_eventi = getData("SELECT * FROM evento e WHERE e.id_categoria =' ".$row["id"]."' ORDER BY e.costo LIMIT 10");
		if($result_eventi == 0){
			//mettere errore	
		}
		foreach( $result_eventi as $row_eventi ){
			if( file_exists($row_eventi['immagine']) ){
				$template -> setContent( "EVENTO_IMMAGINE", $row_eventi['immagine'] );	
			} else {
				if( file_exists($row['immagine']) ){
					$template -> setContent( "EVENTO_IMMAGINE",$row['immagine']);
				} else {
					$template -> setContent( "EVENTO_IMMAGINE","immagini_categoria/error.png");
				}	
			}
			$template -> setContent( "EVENTO_NOME", $row_eventi['nome'] );

			$posti = $row_eventi['posti'];
				$query = "SELECT count(*) as n FROM partecipazione WHERE id_evento={$row_eventi['id']}";
    			$resultPartecipazioni = getData( $query );
				if($resultPartecipazioni == 0){
					//mettere errore	
				}
				$posti -= $resultPartecipazioni[0]['n'];
				$template -> setContent("EVENTO_POSTI", $posti);
			if( isset($row_eventi['costo']) && (strcmp($row_eventi['costo'],0))){
				$template -> setContent( "EVENTO_COSTO", $row_eventi['costo'] );
				$template -> setContent("FLAG", " ");
				$template -> setContent("FLAG_1", "d-none" );
			} else {
				$template -> setContent("FLAG", "d-none");
				$template -> setContent( "FLAG_1", " ");
			}
			
			$template -> setContent( "CATEGORIA_EVENTO", $row['nome'] );
		}
	}
	if(isset($_SESSION["mail"]) ){
		$result_pref = getData( "SELECT c.immagine, c.id FROM categoria_preferita cp JOIN categoria c ON (cp.id_categoria = c.id) JOIN utente u ON (u.id = cp.id_utente) WHERE u.email = '{$_SESSION["mail"]}' " );	
		if($result_pref == 0){
			//mettere errore	
		}
		if(empty($result_pref)){
			$template -> setContent("FLAG-PR","d-none");
		}
		foreach( $result_pref as $row_pref ){
			$result_eventi = getData(" SELECT * FROM evento e WHERE e.id_categoria = {$row_pref["id"]} ORDER BY rand() LIMIT 3 ");
			if($result_eventi == 0){
				//mettere errore	
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
				$template -> setContent("EVENTO_NOME_PREF", $row_eventi_pref["nome"]);

				$posti = $row_eventi_pref['posti'];
				$query = "SELECT count(*) as n FROM partecipazione WHERE id_evento={$row_eventi_pref['id']}";
				$resultPartecipazioni = getData( $query );
				if($resultPartecipazioni == 0){
					//mettere errore	
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
	} else	{
		$template -> setContent("FLAG-PR","d-none");
	}
		

	
	$template -> close();
?>
