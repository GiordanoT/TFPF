<?php
  function AdminSconto( $id_categoria, $sconto){
    $result = setData( "UPDATE categoria SET sconto = {$sconto} WHERE id = {$id_categoria}" );
    return $result;
  }
?>
