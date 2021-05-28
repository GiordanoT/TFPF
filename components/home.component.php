<?php
  error_reporting(E_ALL ^ (E_WARNING | E_NOTICE));

	require_once('include/dbh.inc.php');
	$template = new Template( 'templates/home.template.html' );
	$template -> setContent( "IMMAGINE_CAROUSEL","image/carousel.jpg" );

	function alert($msg) {
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}

	if($_GET["popup"]=="true")
		alert("Ora sei in modalità admin");
	elseif($_GET["popup"]=="false")
		alert("Ora sei in modalità utente");
	

	//EVENTI RECENTI	
	$result_recenti = getData("SELECT DISTINCT e.id as evento_id, e.citta, e.immagine as immagine_e, e.nome as nome_e, e.posti, e.costo, c.nome as nome_c, c.immagine as immagine_c FROM evento e JOIN data_evento d ON (e.id = d.id_evento) JOIN categoria c ON (c.id = e.id_categoria) WHERE e.concluso=0 ORDER BY d.data ASC LIMIT 10");
	if($result_recenti == 0){
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
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
		$queryData = getData("SELECT * FROM data_evento d WHERE d.id_evento = {$row_recenti['evento_id']} ");
		$count = 0;
		foreach( $queryData as $rowData ){
			$query = "SELECT count(*) as n FROM partecipazione p WHERE p.id_data = {$rowData['id']} ";
			$resultPartecipazioni = getData( $query );
			if($resultPartecipazioni == 0){
				require( "components/error.component.php" );
				require( "components/footer.component.php" );
				exit();
			}
			$count += $resultPartecipazioni[0]['n'];
		}
		$posti -= $count;
		$template -> setContent("EVENTO_POSTI_RECENTE", $posti);
	}

	//EVENTI PER CATEGORIA
	$result = getData("SELECT DISTINCT c.* FROM categoria c JOIN evento e ON (c.id = e.id_categoria) ORDER BY c.nome LIMIT 3");
	if($result == 0){
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	}
	if( empty($result) ){
		$template -> setContent("FLAG_CAT","d-none");
	}
	foreach( $result as $row ){
		$result_eventi = getData("SELECT * FROM evento e WHERE e.id_categoria = {$row["id"]} AND e.concluso=0 ORDER BY e.costo LIMIT 10");
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

			$posti = $row_eventi['posti'];
			$queryData = getData("SELECT * FROM data_evento d WHERE d.id_evento = {$row_eventi['id']} ");
			$count = 0;
			foreach( $queryData as $rowData ){
				$query = "SELECT count(*) as n FROM partecipazione p WHERE p.id_data = {$rowData['id']} ";
				$resultPartecipazioni = getData( $query );
				if($resultPartecipazioni == 0){
					require( "components/error.component.php" );
					require( "components/footer.component.php" );
					exit();
				}
				$count += $resultPartecipazioni[0]['n'];
			}
			$posti -= $count;	
			$template -> setContent("EVENTO_POSTI", $posti);

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
			$result_eventi_pref = getData(" SELECT * FROM evento e WHERE e.id_categoria = {$row_pref["id"]} AND e.concluso=0 ORDER BY rand() LIMIT 8 ");
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

				$posti = $row_eventi_pref['posti'];
				$queryDataPref = getData("SELECT * FROM data_evento d WHERE d.id_evento = {$row_eventi_pref['id']} ");
				$count = 0;
				foreach($queryDataPref as $rowDataPref){
					$queryPref = "SELECT count(*) as n FROM partecipazione p WHERE p.id_data = {$rowDataPref['id']} ";
					$resultPartecipazioniPref = getData( $queryPref );
					if($resultPartecipazioniPref == 0){
						require( "components/error.component.php" );
						require( "components/footer.component.php" );
						exit();
					}
					$count += $resultPartecipazioniPref[0]['n'];
				}
				$posti -= $count;	
				$template -> setContent("EVENTO_POSTI_PREF", $posti);
			}
		}
	} else	{
		$template -> setContent("FLAG_PR","d-none");
	}



	$template -> close();
?>
