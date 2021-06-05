<?php
	require_once( "include/dbh.inc.php" );
	session_start();
	$template = new Template( 'templates/utenteSconto.template.html' );
	if( !isset( $_SESSION['mail'] ) || $_SESSION['ruolo'] == 1 ){
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	}
	$result = getData( "SELECT * FROM evento WHERE sconto = 0 AND admin_evento={$_SESSION['id']}" );
	foreach( $result as $row ){
		$template -> setContent( "evento", $row['nome'] );
		$template -> setContent( "evento_value", $row['id'] );
	}
	if( empty( $result ) ){
		$template -> setContent( "disabled", "disabled" );
		$template -> setContent( "messaggio_errore", "NON È POSSIBILE APPLICARE NESSUNO SCONTO" );
	}
	$template -> close();
?>
