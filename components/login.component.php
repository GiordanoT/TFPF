<?php
	$template = new Template( 'templates/login.template.html' );

	if( isset($_GET['error']) ){

		if($_GET['error'] == "empty_fields")
			$template -> setContent("Messaggio_errore", "Login fallito: inserire tutti i campi.");
		else $template -> setContent("Messaggio_errore", "Login fallito: email e/o password errati.");
	}
	
	$template -> close();
?>
