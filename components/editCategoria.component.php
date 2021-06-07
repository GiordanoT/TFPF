<?php
	require_once( "include/dbh.inc.php" );
	session_start();
	$template = new Template( 'templates/editCategoria.template.html' );
	if( $_SESSION['ruolo'] != 1){
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	}

	$result = getData( "SELECT * FROM categoria ");
	foreach( $result as $row ){
	  $template -> setContent( "NOME_EVENTO", $row['nome'] );
	  $template -> setContent( "IMMAGINE_EVENTO", $row['immagine']);
	  $template -> setContent( "ID_DATAEVENTO", $row['id'] );
	}
	if( empty( $result ) || $result == 0 ){
		$template -> setContent( "flag", "d-none" );
		$template -> setContent( "text_errore", "NON CI SONO PROSSIMI EVENTI" );
	}
	$template -> close();
?>
