<?php
	require_once( "include/dbh.inc.php" );

	$template = new Template( 'templates/registrati.template.html' );

	if(isset($_GET["errore"])){
		$template -> setContent( "hidden", "" );
		if($_GET["errore"] == "password" ) $template -> setContent( "Messaggio_errore", " Le due password non sono uguali. " );
		if($_GET["errore"] == "email" ) $template -> setContent( "Messaggio_errore", " L' E-mail risulta già registrata. " );

	}else
		$template -> setContent( "hidden", "hidden" );


	$template -> close();
?>
