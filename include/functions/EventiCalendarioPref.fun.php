<?php
  function EventiCalendarioPref( $data, $utente ){
    $query = "SELECT DISTINCT evento.* FROM preferito,data_evento,evento WHERE id_utente='{$utente}' AND data='{$data}' AND id_evento=evento.id AND id_data = data_evento.id ";
    $resultEvento = getData( $query );
    if( $resultEvento == 0 || empty( $resultEvento ) ){ return 0; }
    $result = array();
    array_push( $result, 1, $resultEvento );
    return $result;
  }
?>
