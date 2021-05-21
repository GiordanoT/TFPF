<?php
    function ScegliDate($durata, $giorno, $ora_inizio, $ora_fine){

        for($i = 1; $i <= (int)$durata; $i++){

            for($k = $i+1; $k <=(int)$durata; $k++){
                if($giorno[$i] == $giorno[$k])
                    return 0;
            }
            
            $oggi = date("Y-m-d");

            if($giorno[$i] < $oggi || $ora_fine[$i] <= $ora_inizio[$i]){
                return 0;
            }
            
            $oggi_ora = date("h:i");
            echo var_dump($oggi_ora);
            if($giorno[$i] == $oggi && $ora_inizio[$i] < $oggi_ora)
                return 0;
        }
        for($i = 1; $i <= (int)$durata; $i++){
 
            $result_id_evento = getData("SELECT MAX(id) AS id_evento FROM evento");

            if(!$result_id_evento)
                return 2;
            
            $row_evento = $result_id_evento[0];
            $id_evento = $row_evento['id_evento'];

            $query = "INSERT INTO data_evento (id_evento,data,ora_inizio,ora_fine)
                      VALUES ('{$id_evento}','{$giorno[$i]}','{$ora_inizio[$i]}','{$ora_fine[$i]}');";

            $result = setData($query);

           if(!$result)
                return 2;
        }
        return 1;
    }
?>