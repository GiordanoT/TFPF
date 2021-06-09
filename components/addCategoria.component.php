<?php
	require_once( "include/dbh.inc.php" );
	session_start();
	$template = new Template( 'templates/addCategoria.template.html' );
	if($_SESSION['ruolo'] != 1){
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	}
	if( isset( $_GET['id'] ) ){
		$id = $_GET['id'];
		$template -> setContent( "ID", $id );
		$query = "SELECT * FROM categoria WHERE id={$id}";
		$result = getdata( $query );
		if ( empty($result) || !is_numeric($id) ){
			$template -> setContent( "LINK", "addCategoria.inc.php" );
			$template -> setContent( "REQUIRED", "required" );
			$template -> setContent( "BUTTON", "Aggiungi" );
		}
		else{
			$template -> setContent( "NOME", $result[0]['nome'] );
			$template -> setContent( "LINK", "editCategoria.inc.php" );
			$template -> setContent( "REQUIRED", "" );
			$template -> setContent( "BUTTON", "Modifica" );
		}

	}
	else{
		$template -> setContent( "LINK", "addCategoria.inc.php" );
		$template -> setContent( "REQUIRED", "required" );
		$template -> setContent( "BUTTON", "Aggiungi" );
	}
	$template -> close();
?>
