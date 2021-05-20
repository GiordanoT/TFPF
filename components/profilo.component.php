<?php
	$template = new Template( 'templates/profilo.template.html' );
	if( !isset( $_SESSION['mail']) ){
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	}

    $template -> setContent("nome", $_SESSION['nome']);
    $template -> setContent("cognome", $_SESSION['cognome']);
    $template -> setContent("email", $_SESSION['mail']);

	$template -> close();
?>
