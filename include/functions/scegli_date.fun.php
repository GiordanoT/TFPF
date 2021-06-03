<?php
    function ScegliDate($durata, $giorno, $ora_inizio, $ora_fine, $prezzo_data, $prezzo_totale){

        for($i = 1; $i <= (int)$durata; $i++){
            
            for($k = $i+1; $k <=(int)$durata; $k++){
                if($giorno[$i] == $giorno[$k])
                    return 0;
            }

            $oggi = date("Y-m-d");

            if($giorno[$i] < $oggi || $ora_fine[$i] <= $ora_inizio[$i]){
                return 0;
            }

            if((float)$prezzo_data[$i] < 0){
                return 0;
            }

            $oggi_ora = date("h:i");
        
            if($giorno[$i] == $oggi && $ora_inizio[$i] < $oggi_ora)
                return 0;
        }

        if((float)$prezzo_totale < 0){
            return 0;
        }

        for($i = 1; $i <= (int)$durata; $i++){

            $result_id_evento = getData("SELECT MAX(id) AS id_evento FROM evento");

            if(!$result_id_evento)
                return 2;

            $row_evento = $result_id_evento[0];
            $id_evento = $row_evento['id_evento'];

            if($durata == 1)
                $prezzo_data[$i] = $prezzo_totale;

            $query = "INSERT INTO data_evento (id_evento,data,ora_inizio,ora_fine,costo)
                      VALUES ('{$id_evento}','{$giorno[$i]}','{$ora_inizio[$i]}','{$ora_fine[$i]}', '{$prezzo_data[$i]}');";

            $result = setData($query);

            if(!$result)
                return 2;

            $query = "UPDATE evento SET costo = '{$prezzo_totale}' WHERE id = '{$id_evento}'";

            $result = setData($query);

            if(!$result)
                return 2;
        }
        return 1;
    }
?>
