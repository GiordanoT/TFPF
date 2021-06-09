<?php  
    function EsistenzaDate($id){
        $risultatoEvento = getData("SELECT count(*) as conta FROM data_evento as da WHERE da.id_evento='{$id}'");
        return $risultatoEvento[0]["conta"];
    }
?>