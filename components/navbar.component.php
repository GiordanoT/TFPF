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
		$template -> setContent( "LINK", "#" );
		$template -> setContent( "ICON", "fa-calendar-alt" );
		//PREFERITI
		$template -> setContent( "NOME_LINK", "Categorie Preferite" );
		$template -> setContent( "LINK", "gestionePreferiti.php" );
		$template -> setContent( "ICON", "fa-heart" );
		//PROFILO
		$template -> setContent( "NOME_LINK", "Profilo" );
		$template -> setContent( "LINK", "profilo.php" );
		$template -> setContent( "ICON", "fa-user" );
		//ADMIN
		if(getData( "SELECT ruolo FROM utente where email='{$_SESSION['mail']}' AND ruolo='0'")){
			$template -> setContent( "NOME_LINK", "Passa ad profilo admin" );
			$template -> setContent( "LINK", "include/adminevento.inc.php" );
			$template -> setContent( "ICON", "fas fa-users-cog" );
		}else{
		//EVENTI CREATI
			$template -> setContent( "NOME_LINK", "Eventi creati" );
			$template -> setContent( "LINK", "eventicreati.php" );
			$template -> setContent( "ICON", "fas fa-list" );

			$template -> setContent( "NOME_LINK", "Passa ad profilo utente" );
			$template -> setContent( "LINK", "include/adminevento.inc.php" );
			$template -> setContent( "ICON", "fas fa-users-cog" );
		}		
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
