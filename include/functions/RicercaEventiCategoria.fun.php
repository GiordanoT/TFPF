<?php
  function ricercaEventiCategoria( $c ){
    $query = "SELECT * FROM evento WHERE concluso=0 AND id_categoria={$c} AND approvato=1";
    $resultEvento = getData( $query );
    if( $resultEvento == 0 ) return 0;
    $result = array();
    array_push( $result, 1, $resultEvento );
    return $result;
  }
?>
