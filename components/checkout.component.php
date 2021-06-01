<?php

  session_start();
  $template = new Template( 'templates/checkout.template.html' );

  $nomeutente = $_SESSION["nome"];
  $cognomeutente = $_SESSION["cognome"];
  $emailutente = $_SESSION['mail'];


  $array = array();
  for($i=0; $i<=6; $i++){
    if(  isset($_POST[$i]) ){
      array_push( $array, $_POST[$i] );
    }
  }

  $loggato=0;

  if(isset($nomeutente))
    $loggato=1;


  if($loggato==1)
  $template -> setContent( "Variabile", "readonly" );
  $data = date("d-m-Y");
  $template -> setContent( "DATA_ATTUALE", $data );
  $template -> setContent( "NOME_UTENTE", "{$nomeutente}" );
  $template -> setContent( "COGNOME_UTENTE", "{$cognomeutente}" );
  $template -> setContent( "EMAIL_UTENTE", $emailutente );

  $template -> setContent( "CODICE_ORDINE", rand(0,1000) );

  $prezzotot = 0;


    //PARTECIPA A TUTTE LE DATE
    $indice = 0;
    if($array == null){

      $evento = $_POST["evento"];
      $result_date = getData("SELECT de.id as de_id, e.nome as nomeeve, de.data as datada, e.descrizione as descrizione, de.costo as prezzo  FROM data_evento as de join evento as e on (e.id = de.id_evento) where de.id_evento= '{$evento}'");

      foreach( $result_date as $rowdate){
        if($rowdate["datada"] > date("Y-m-d")){
          $template -> setContent( "NOME_INPUT_EVENTO", $indice );
          $template -> setContent( "ID_DATA", $rowdate["de_id"] );
          $template -> setContent( "NOME_EVENTO", $rowdate["nomeeve"] );
          $template -> setContent( "DATA_EVENTO", $rowdate["datada"] );
          $template -> setContent( "DESCRIZIONE_EVENTO", $rowdate["descrizione"] );
          $template -> setContent( "PREZZO_EVENTO", $rowdate["prezzo"] );
          $prezzotot = $prezzotot + $rowdate["prezzo"];
          $indice++;
        }
      }
    }else{
      //PARTECIPA A DATE SELEZIONATE
      foreach($array as $dataevento){
        $result_date = getData("SELECT de.id as de_id, e.nome as nomeeve, de.data as datada, e.descrizione as descrizione, de.costo as prezzo  FROM data_evento as de join evento as e on (e.id = de.id_evento) where de.id= '{$dataevento}'");
        $rowdate = $result_date[0];
        $template -> setContent( "NOME_INPUT_EVENTO", $indice );
        $template -> setContent( "ID_DATA", $rowdate["de_id"] );
        $template -> setContent( "NOME_EVENTO", $rowdate["nomeeve"] );
        $template -> setContent( "DATA_EVENTO", $rowdate["datada"] );
        $template -> setContent( "DESCRIZIONE_EVENTO", $rowdate["descrizione"] );
        $template -> setContent( "PREZZO_EVENTO", $rowdate["prezzo"] );
        $prezzotot = $prezzotot + $rowdate["prezzo"];
        $indice++;
      }
    }
  $template -> setContent( "COSTO_TOTALE", $prezzotot );
  $template -> close();

?>
