<?php
	session_start();
	require_once( "include/dbh.inc.php" );
	$template = new Template( 'templates/navbar.template.html' );


	$resultCategoria = getData( "SELECT * FROM categoria" );
		if( $resultCategoria == 0 ){
			$template -> setContent( "CATEGORIA", "ERRORE !" );
			$template -> setContent( "LINK_CATEGORIA", "error.php" );
		}
	foreach( $resultCategoria as $rowCategoria ){
		$template -> setContent( "CATEGORIA", $rowCategoria['nome'] );
		$template -> setContent( "LINK_CATEGORIA", "#" );
	}

	if( isset($_SESSION['mail']) ){
		$template -> setContent( "FLAG_PROFILO", "d-flex" );
		$template -> setContent( "NOME", $_SESSION['nome'] );
		$template -> setContent( "COGNOME", $_SESSION['cognome'] );

		//CALENDARIO
		$template -> setContent( "NOME_LINK", "Calendario" );
		$template -> setContent( "LINK", "calendario.php" );
		$template -> setContent( "ICON", "fa-calendar-alt" );
		//PREFERITI
		$template -> setContent( "NOME_LINK", "Categorie Preferite" );
		$template -> setContent( "LINK", "gestionePreferiti.php" );
		$template -> setContent( "ICON", "fa-heart" );
		//PROFILO
		$template -> setContent( "NOME_LINK", "Profilo" );
		$template -> setContent( "LINK", "profilo.php" );
		$template -> setContent( "ICON", "fa-user" );
		//LOGOUT
		$template -> setContent( "NOME_LINK", "Logout" );
		$template -> setContent( "LINK", "include/logout.inc.php" );
		$template -> setContent( "ICON", "fa-sign-out-alt" );
	}
	else{
		$template -> setContent( "FLAG_PROFILO", "d-none" );
		//ACCEDI
		$template -> setContent( "NOME_LINK", "Accedi" );
		$template -> setContent( "LINK", "login.php" );
		$template -> setContent( "ICON", "fa-user-check" );
		//REGISTRATI
		$template -> setContent( "NOME_LINK", "Registrati" );
		$template -> setContent( "LINK", "registrati.php" );
		$template -> setContent( "ICON", "fa-user-edit" );
	}
	$template -> close();
?>
