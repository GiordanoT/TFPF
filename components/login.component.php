<?php
	$template = new Template( 'templates/login.template.html' );
	if( isset($_SESSION['mail']) ){
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	}
	if( isset($_GET['error']) ){
		$template -> setContent("Messaggio_errore", "Email e/o password errati.");
	}

	$template -> close();
?>
