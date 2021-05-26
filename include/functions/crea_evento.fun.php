<?php  
    function creaEvento($nome,$descrizione,$tipologia,$categoria,$posti,$admin,$costo,$path_immagine,$citta,$concluso,$approvato){

        if( ((int)$posti <= 0) || (float)$costo < 0)
            return 0;
        
        $query = "INSERT INTO evento (nome,descrizione,id_categoria,tipologia,posti,admin_evento,costo,immagine,citta,concluso,approvato) 
                  VALUES ( '{$nome}','{$descrizione}','{$categoria}','{$tipologia}','{$posti}','{$admin}','{$costo}','{$path_immagine}','{$citta}',0,2); ";
  
        $result = setData($query);
        
        if($result)
            return 1;
        else return 2;

    }
?>