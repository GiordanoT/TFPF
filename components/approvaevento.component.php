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

	$result = getData( "SELECT e.nome as nome, e.immagine as immagine, c.immagine as immagine_c, e.id as id  FROM evento as e join categoria as c on (c.id = e.id_categoria) where approvato = '2'" );
	
	foreach( $result as $row ){
            $template -> setContent( "NOME_EVENTO", $row['nome'] );
            $resultConta = getData( "SELECT count(*) as conta from data_evento where id_evento='{$row['id']}'" );
            $conta=$resultConta[0];
            $template -> setContent( "NUMERO_DATA_EVENTO", $conta['conta'] );
			if( file_exists($row['immagine']) ){
				$template -> setContent( "IMMAGINE_EVENTO", $row['immagine'] );
			} else {
				if( file_exists($row['immagine_c']) ){
					$template -> setContent( "IMMAGINE_EVENTO",$row['immagine_c']);
				} else {
					$template -> setContent( "IMMAGINE_EVENTO","immagini_categoria/error.png");
				}
			}
							
            $template -> setContent( "ID_EVENTO", $row['id'] );
	}
	if( empty( $result ) || $result == 0 ){
		$template -> setContent( "flag", "d-none" );
		$template -> setContent( "text_errore", "NON CI SONO EVENTI DA APPROVARE!" );
	}


    $template -> close();
?>