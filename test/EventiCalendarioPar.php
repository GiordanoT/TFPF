<?php
  function EventiCalendarioPar( $data, $utente ){
    $query = "SELECT evento.nome as nome FROM partecipazione,data_evento,evento WHERE id_utente='{$utente}' AND data='{$data}' AND partecipazione.id_evento=evento.id AND data_evento.id_evento = evento.id ";
    echo $query."<br>";
    $resultEvento = getData( $query );
    if( $resultEvento == 0 || empty( $resultEvento ) ){ return 0; }
    $result = array();
    array_push( $result, 1, $resultEvento );
    return $result;
  }
?>
