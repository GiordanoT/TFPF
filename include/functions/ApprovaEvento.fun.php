<?php
  function ApprovaEvento( $id, $del){
    
    if($del == 1){
        $result = setData("UPDATE evento set approvato='0' where id= '{$id}'");
        return $result;

    }elseif($del == 0){
        $result = setData("UPDATE evento set approvato='1' where id= '{$id}'");
        return $result;
    }
    return 0;
  }
?>