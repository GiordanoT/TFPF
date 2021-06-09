<?php
  error_reporting(E_ALL ^ (E_WARNING | E_NOTICE));

	require_once('include/dbh.inc.php');
	$template = new Template( 'templates/home.template.html' );
	
	$dataOdierna = date('Y-m-d');
	date_default_timezone_set('Europe/Rome');
	$oggi_ora = date("h:i");

	$result_ev = getData("SELECT * FROM evento");
	foreach($result_ev as $row_ev){
		$result_d = getData("SELECT * FROM data_evento d where d.id_evento = {$row_ev['id']} ");
		$sem = 0;
		foreach($result_d as $row_d){
			if($row_d['data'] > $dataOdierna || ($row_d['data'] == $dataOdierna && $row_d['ora_inizio'] > $oggi_ora) ){ $sem=1;}
		}
		if($sem == 0){
			$setta_concluso = setData("UPDATE evento SET concluso = 1 WHERE id = {$row_ev['id']} ");
		}

	}
	
	$template -> setContent( "IMMAGINE_CAROUSEL","image/carousel.jpg" );

	function alert($msg) {
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}

	if($_GET["popup"]=="true")
		alert("Ora sei in modalità admin");
	elseif($_GET["popup"]=="false")
		alert("Ora sei in modalità utente");
	



	//EVENTI RECENTI	
	$eventi_recenti = getData("SELECT DISTINCT e.id as evento_id, e.citta, e.immagine as immagine_e, e.nome as nome_e, e.posti, e.costo as costo_e, c.nome as nome_c, c.immagine as immagine_c, c.sconto as c_sconto FROM evento e JOIN categoria c ON (c.id = e.id_categoria) JOIN data_evento d ON (d.id_evento = e.id) WHERE e.concluso = 0 AND e.approvato = 1 AND d.data > '{$dataOdierna}' ORDER BY d.data DESC LIMIT 10");

	if($eventi_recenti == 0){
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	}

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

	//EVENTI PER CATEGORIA
	$result = getData("SELECT DISTINCT c.* FROM categoria c JOIN evento e ON (c.id = e.id_categoria) WHERE e.approvato=1 AND e.concluso=0 ORDER BY c.nome LIMIT 3");
	if($result == 0){
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	}
	if( empty($result) ){
		$template -> setContent("FLAG_CAT","d-none");
	}
	foreach( $result as $row ){
		$result_eventi = getData("SELECT * FROM evento e WHERE e.id_categoria = {$row["id"]} AND e.concluso=0 AND e.approvato=1 ORDER BY e.costo LIMIT 10");
		if($result_eventi == 0){
			require( "components/error.component.php" );
			require( "components/footer.component.php" );
			exit();
		}

		$template -> setContent( "CATEGORIA", strtoupper($row['nome']) );
		if( file_exists($row['immagine']) ){
			$template -> setContent( "CATEGORIA_IMMAGINE", $row['immagine'] );
		} else {
			$template -> setContent( "CATEGORIA_IMMAGINE","immagini_categoria/error.png");
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
			$template -> setContent( "EVENTO_CITTA", $row_eventi['citta'] );
			$template -> setContent( "LINK_EVENTO", "evento.php?id=".$row_eventi['id'] );
			$template -> setContent( "EVENTO_NOME", $row_eventi['nome'] );

			$prezzoMin = $row_eventi['costo'];

			$result_prezzo = getData("SELECT MIN(costo) as costoMin FROM data_evento WHERE id_evento = {$row_eventi['id']} AND data > '{$dataOdierna}'");
			$row_prezzo = $result_prezzo[0]['costoMin'];
			
			if($row_prezzo == "0" || $prezzoMin == "0"){
				$template -> setContent( "EVENTO_COSTO", "GRATIS" );
				$template -> setContent( "VARIABILE_COSTO", 'style="color: red;"' );
			} else {
				if( $prezzoMin < $row_prezzo){
					$template -> setContent( "VARIABILE_COSTO", "" );
					$template -> setContent( "EVENTO_COSTO", "DA: {$prezzoMin} €" );
				} else {
					$template -> setContent( "VARIABILE_COSTO", "" );
					$template -> setContent( "EVENTO_COSTO", "DA: {$row_prezzo} €" );
				}
	
			}
	
			$template -> setContent( "CATEGORIA_EVENTO", $row['nome'] );
		}
	}


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
				$template -> setContent("FLAG_PR","d-none");

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



	$template -> close();
?>
