<?php

    if(isset($_SESSION['id'])){

        session_start();

        $template = new Template( 'templates/scegliDate.template.html' );

        $giorni = (int)$_SESSION['giorni'];

        if(isset($_GET['error'])){
            if($_GET['error'] == "bad_data")
                $template -> setContent("Messaggio_errore", "Inserire correttamente i dati");
            else 
                $template -> setContent("Messaggio_errore", "Errore durante l'operazione, riprovare");
        }

        $_SESSION['pagina_visitata'] = 1;

        for($i = 1; $i <= $giorni; $i++){
            $template -> setContent("numero_data",$i);
            $template -> setContent("data", "data_".$i);
            $template -> setContent("inizio", "inizio_".$i);
            $template -> setContent("fine", "fine_".$i);
            $template -> setContent("prezzo", "prezzo_".$i);

        }

        if($giorni == 1){
            $template -> setContent("label_hidden", "hidden");
            $template -> setContent("input_hidden", "hidden");
            $template -> setContent("label_prezzo", "Prezzo del biglietto:");
        }
        else{
            $template -> setContent("required", "required");
            $template -> setContent("label_prezzo", "Prezzo del pacchetto completo:");
        }
        
        $template -> setContent("num_giorni", $giorni);


        $template -> close();
    }
    else {
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	}
?>
