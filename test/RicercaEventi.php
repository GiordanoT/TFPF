<?php
  function ricercaEventi( $s ){
    $query = "SELECT * FROM evento WHERE nome LIKE '%{$s}%'";
    $resultEvento = getData( $query );
    if( $resultEvento == 0 ) return 0;
    $result = array();
    array_push( $result, 1, $resultEvento );
    return $result;
  }
?>
