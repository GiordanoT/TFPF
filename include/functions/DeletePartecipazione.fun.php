<?php  
    function DeletePartecipazione($id){
        $result = setData("DELETE FROM partecipazione where id='{$id}'");

        return $mysqli->affected_rows;
    }
?>