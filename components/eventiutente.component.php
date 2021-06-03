<?php
	require_once( "include/dbh.inc.php" );
	session_start();
	$template = new Template( 'templates/eventiutente.template.html' );
	if( !isset( $_SESSION['mail'] ) || $_SESSION['ruolo'] == 1){
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	}

    $utente = $_SESSION["id"];

	$result = getData( "SELECT p.id as id, e.immagine as immagine, e.nome as nome, de.data as data FROM partecipazione as p join data_evento as de on (de.id = p.id_data) 
                        join evento as e on (e.id = de.id_evento) where p.id_utente = {$utente}" );
	$i=1;
	foreach( $result as $row ){
        if(date("Y-m-d") < $row['data'] ){
            $template -> setContent( "NOME_EVENTO", $row['nome'] );
            $template -> setContent( "DATA_EVENTO", $row['data'] );
            $template -> setContent( "IMMAGINE_EVENTO", $row['immagine']);
            $template -> setContent( "ID_DATAEVENTO", $row['id'] );
        }
	}
	if( empty( $result ) || $result == 0 ){
		$template -> setContent( "flag", "d-none" );
		$template -> setContent( "text_errore", "NON CI SONO PROSSIMI EVENTI" );
	}
	$template -> close();
?>