<?php
	require_once( "include/dbh.inc.php" );
	session_start();
	$template = new Template( 'templates/elencoScontiUtente.template.html' );
	if( !isset( $_SESSION['mail'] ) || $_SESSION['ruolo'] == 1){
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	}
	$result = getData( "SELECT * FROM evento WHERE sconto > 0 AND admin_evento = {$_SESSION['id']}" );
	$i=1;
	foreach( $result as $row ){
		$template -> setContent( "nome", $row['nome'] );
		$template -> setContent( "sconto", $row['sconto'] );
		$template -> setContent( "n", $i ); $i++;
		$template -> setContent( "id_evento", $row['id'] );
	}
	if( empty( $result ) || $result == 0 ){
		$template -> setContent( "flag", "d-none" );
		$template -> setContent( "text_errore", "NON SONO PRESENTI SCONTI" );
	}
	$template -> close();
?>
