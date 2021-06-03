<?php
  function ricercaEventi( $s ){
    $query = "SELECT * FROM evento WHERE concluso=0 AND approvato=1 AND nome LIKE '%{$s}%'";
    $resultEvento = getData( $query );
    if( $resultEvento == 0 ) return 0;
    $result = array();
    array_push( $result, 1, $resultEvento );
    return $result;
  }
  
?>
