<?php
	require_once( "include/dbh.inc.php" );
	session_start();
	$template = new Template( 'templates/approvaevento.template.html');

    if($_SESSION["ruolo"] == 0){
        require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
    }

    $utente = $_SESSION["id"];

	$result = getData( "SELECT * FROM evento where approvato = '2'" );
	
	foreach( $result as $row ){
            $template -> setContent( "NOME_EVENTO", $row['nome'] );
            $resultConta = getData( "SELECT count(*) as conta from data_evento where id_evento='{$row['id']}'" );
            $conta=$resultConta[0];
            $template -> setContent( "NUMERO_DATA_EVENTO", $conta['conta'] );
			$template -> setContent( "IMMAGINE_EVENTO", $row['immagine']);				
            $template -> setContent( "ID_EVENTO", $row['id'] );
	}
	if( empty( $result ) || $result == 0 ){
		$template -> setContent( "flag", "d-none" );
		$template -> setContent( "text_errore", "NON CI SONO EVENTI DA APPROVARE!" );
	}


    $template -> close();
?>