<?php
	require_once( "include/dbh.inc.php" );
	$template = new Template( 'templates/elencoScontiAdmin.template.html' );
	if($_SESSION['ruolo'] != 1){
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	}
	$result = getData( "SELECT * FROM categoria WHERE sconto > 0" );
	$i=1;
	foreach( $result as $row ){
		$template -> setContent( "nome", $row['nome'] );
		$template -> setContent( "sconto", $row['sconto'] );
		$template -> setContent( "n", $i ); $i++;
		$template -> setContent( "id_categoria", $row['id'] );
	}
	if( empty( $result ) ){
		$template -> setContent( "flag", "d-none" );
		$template -> setContent( "text_errore", "NON SONO PRESENTI SCONTI" );
	}
	$template -> close();
?>
