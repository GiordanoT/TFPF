<?php
  function UtenteSconto( $id_evento, $sconto){
    $result = setData( "UPDATE evento SET sconto = {$sconto} WHERE id = {$id_evento}" );
    return $result;
  }
?>
