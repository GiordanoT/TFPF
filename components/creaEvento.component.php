<?php
	
	if(isset($_SESSION['id'])){
		
		require_once('include/dbh.inc.php');

		session_start();

		$template = new Template( 'templates/creaEvento.template.html' );

		if( isset($_GET['error'])){
			if($_GET['error'] == "bad_data")
				$template -> setContent("Messaggio_errore", "Inserire correttamente i dati");
			else 
				$template -> setContent("Messaggio_errore", "Errore durante l'operazione, riprovare");
		}

		if($_SESSION['pagina_visitata'] == 1){
			$_SESSION['pagina_visitata'] = 0;

			$result_id_evento = getData("SELECT MAX(id) AS id_evento FROM evento");

            if(!$result_id_evento)
                return 2;
            
            $row_evento = $result_id_evento[0];
            $id_evento = $row_evento['id_evento'];

			$result = setData("DELETE FROM evento WHERE id ='{$id_evento}'");
		}

		$result_categorie = getData("SELECT id,nome FROM categoria");

		foreach($result_categorie as $row_categoria){
			$template -> setContent("categoria_value", $row_categoria['id']);
			$template -> setContent("categoria", $row_categoria['nome']);
		}
		$template -> close();
	}
	else {
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	}
?>
