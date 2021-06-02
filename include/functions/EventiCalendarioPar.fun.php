<?php
  function EventiCalendarioPar( $data, $utente ){
    $query = "SELECT DISTINCT evento.* FROM partecipazione,data_evento,evento WHERE id_utente='{$utente}' AND data='{$data}' AND data_evento.id = partecipazione.id_data AND data_evento.id_evento = evento.id ";
    $resultEvento = getData( $query );
    if( $resultEvento == 0 || empty( $resultEvento ) ){ return 0; }
    $result = array();
    array_push( $result, 1, $resultEvento );
    return $result;
  }
?>
