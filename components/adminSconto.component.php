<?php
	require_once( "include/dbh.inc.php" );
	$template = new Template( 'templates/adminSconto.template.html' );
	if($_SESSION['ruolo'] != 1){
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	}
	$result = getData( "SELECT * FROM categoria WHERE sconto = 0" );
	foreach( $result as $row ){
		$template -> setContent( "categoria", $row['nome'] );
		$template -> setContent( "categoria_value", $row['id'] );
	}
	if( empty( $result ) ){
		$template -> setContent( "disabled", "disabled" );
		$template -> setContent( "messaggio_errore", "NON È POSSIBILE APPLICARE NESSUNO SCONTO" );
	}
	$template -> close();
?>
