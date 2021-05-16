<?php
  require_once( "include/dbh.inc.php" );
	$template = new Template( 'templates/ricercaEventi.template.html' );
  if(isset($_POST['search'])) {
    $search = str_replace(" ", "", $_POST['search']);
    $template -> setContent( "ID_SEARCH", $search );
  }
  else{
    $search = $_POST['id_search'];
    $template -> setContent( "ID_SEARCH", $search );
  }
  $template -> setContent( "RICERCA", $search );
  $resultEvento = ricercaEventi( $search );
  if( $resultEvento == 0 ){ require( "components/error.component.php" ); require( "components/footer.component.php" ); exit(); } //errore con DB
  if( !isset($_POST['previous']) && !isset($_POST['next']) ) {
    $template -> setContent( "ID_RICERCA", 0 );
    $template -> setContent( "FLAG_PREVIOUS", "d-none" );
    $indicePagina = 0;
  }
  else{
    $indicePagina = $_POST['indice'];
  }
  //GESTIONE PAGINAZIONE
  if( isset($_POST['previous'])) { $template -> setContent( "ID_RICERCA", $_POST['indice']-9 ); $indicePagina -= 9; }
  if( isset($_POST['next'])) { $template -> setContent( "ID_RICERCA", $_POST['indice']+9 ); $indicePagina += 9; }
  if( $indicePagina == 0 ){ $template -> setContent( "FLAG_PREVIOUS", "d-none" ); }

  $i = 0;
  while( $i < 9 && isset( $resultEvento[$indicePagina] ) ){
    $template -> setContent( "LINK", "#" );//MODIFICARE LINK CON PAGINA EVENTO
    $template -> setContent( "NOME", $resultEvento[$indicePagina]['nome'] );
    $template -> setContent( "CITTA", $resultEvento[$indicePagina]['citta'] );
    $posti = $resultEvento[$indicePagina]['posti'];
    $query = "SELECT count(*) as n FROM partecipazione WHERE id_evento={$resultEvento[$indicePagina]['id']}";
    $resultPartecipazioni = getData( $query );
    if( $resultPartecipazioni == 0 ){ header( "Location: error.php" ); exit(); } //errore con DB
    $posti -= $resultPartecipazioni[0]['n'];
    $template -> setContent( "DISPONIBILE", $posti );
    $resultCategoria = getData( "SELECT * FROM categoria WHERE id = {$resultEvento[$indicePagina]['id_categoria']}" );
    if( $resultCategoria == 0 ){ require( "components/error.component.php" ); require( "components/footer.component.php" ); exit(); } //errore con DB
    $rowCategoria = $resultCategoria[0];
    $template -> setContent( "CATEGORIA", $rowCategoria['nome'] );
    if( file_exists( $resultEvento[$indicePagina]['immagine'] ) ){
      $template -> setContent( "IMMAGINE", $resultEvento[$indicePagina]['immagine'] );
    }
    else{
      $template -> setContent( "IMMAGINE", $rowCategoria['immagine'] );
    }
    $indicePagina++;
    $i++;
  }
    if( $indicePagina >= count( $resultEvento ) ){ $template -> setContent( "FLAG_NEXT", "d-none" );  }
    $query = "SELECT count(*) as n FROM evento WHERE nome LIKE '%{$search}%'";
    $resultEvento = getData( $query );
    if( $resultEvento == 0 ){ require( "components/error.component.php" ); require( "components/footer.component.php" ); exit(); } //errore con DB

    if( $resultEvento[0]['n'] == 1 ){
      $template -> setContent( "N_RICERCA", $resultEvento[0]['n']." risultato" );
    }
    else{
      $template -> setContent( "N_RICERCA", $resultEvento[0]['n']." risultati" );
    }
    if( $resultEvento[0]['n'] <= 0 ){
      $template -> setContent( "CARD_FLAG", "d-none" );
    }
  $template -> close();

  function ricercaEventi( $s ){
    $query = "SELECT * FROM evento WHERE nome LIKE '%{$s}%'";
    $resultEvento = getData( $query );
    return $resultEvento;
  }
?>
