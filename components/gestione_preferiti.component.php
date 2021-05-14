<?php
	session_start();
	$email=$_SESSION["mail"];

	$template = new Template( 'templates/gestione_preferiti.template.html' );
	
	$resultCat = getData( " SELECT * FROM categoria " );
	foreach( $resultCat as $rowCat ){
		$template -> setContent( "nome_categoria", $rowCat['nome'] );
		$template -> setContent( "percorso", $rowCat['immagine'] );
		$template -> setContent( "id_categoria", $rowCat['id'] );

		$resultPref = getData( " select id_categoria from categoria_preferita as cp join utente as u on (u.id = cp.id_utente) where u.email='".$email."' && cp.id_categoria='".$rowCat["id"]."'" );
		
			if(!empty($resultPref)) {
				$template -> setContent( "variabile", "danger" );
				$template -> setContent( "bottone", "Rimuovi" );
				$template -> setContent( "elimina", "1" );
				
			}else{
				$template -> setContent( "variabile", "primary" );
				$template -> setContent( "bottone", "Preferiti" );
				$template -> setContent( "elimina", "0" );

			}
	}




	$template -> close();
?>
