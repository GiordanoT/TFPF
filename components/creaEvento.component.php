<?php
	
	if(isset($_SESSION['id'])){
		
		require_once('include/dbh.inc.php');

		$template = new Template( 'templates/creaEvento.template.html' );

		if( isset($_GET['error'])){
			if($_GET['error'] == "bad_data")
				$template -> setContent("Messaggio_errore", "Inserire correttamente i dati");
			else 
				$template -> setContent("Messaggio_errore", "Errore durante l'operazione, riprovare");
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
