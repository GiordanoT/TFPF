<?php
	$template = new Template( 'templates/profilo.template.html' );

    $template -> setContent("nome", $_SESSION['nome']);
    $template -> setContent("cognome", $_SESSION['cognome']);
    $template -> setContent("email", $_SESSION['mail']);
    $template -> setContent("password", $_SESSION['password']);

	$template -> close();
?>