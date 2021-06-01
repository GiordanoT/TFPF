<?php
  function VisualizzaBiglietto( $id ){
    if( !is_numeric( $id ) ) return 0;
    $query = "SELECT  ora_inizio, ora_fine, data, categoria.nome as nome_categoria, citta, evento.nome as nome_evento FROM partecipazione,data_evento, evento, categoria WHERE codice = {$id} AND partecipazione.id_data = data_evento.id AND evento.id = data_evento.id_evento AND evento.id_categoria = categoria.id";
    $result = getData( $query );
    if( empty( $result ) ) return 0;

    $query = "SELECT * FROM partecipazione WHERE codice = {$id}";
    $resultUser = getData( $query );
    if( empty( $resultUser ) ) return 0;



    $array = array();
    $result = $result[0];
    array_push( $array, $result['data'] );
    array_push( $array, $result['nome_categoria'] );
    array_push( $array, $result['citta'] );
    array_push( $array, $result['nome_evento'] );
    $inizio = $result['ora_inizio'][0].$result['ora_inizio'][1].$result['ora_inizio'][2].$result['ora_inizio'][3].$result['ora_inizio'][4];
    array_push( $array, $inizio  );
    $fine = $result['ora_fine'][0].$result['ora_fine'][1].$result['ora_fine'][2].$result['ora_fine'][3].$result['ora_fine'][4];
    array_push( $array, $fine );
    array_push( $array, $resultUser[0]['intestatario'] );
    array_push( $array, $resultUser[0]['codice'] );
    return $array;
  }
?>
