<?php
    function CancellaData($id_data, $id_evento){

        if($id_data != 0){

            $query = "DELETE FROM data_evento WHERE id = '{$id_data}'";

            $result = setData($query);

            if(!$result)
                return 0;

            $query = "SELECT count(evento.id) as NumDate FROM data_evento,evento WHERE id_evento = '{$id_evento}' AND data_evento.id_evento = evento.id";
            $result_num_data = getData($query);
            $num_date = $result_num_data[0]['NumDate'];

            if($num_date > 0){
                $query = "SELECT data,ora_inizio FROM data_evento,evento WHERE id_evento = '{$id_evento}' AND data_evento.id_evento = evento.id";
                $resultDateEvento = getData($query);
                $data_odierna = date("Y-m-d");
                $ora_odierna = date("h:i");
                $sem = 0;
                $date_passate = 0;

                foreach($resultDateEvento as $rowDataEvento){
                    $data_limite = date('Y-m-d', strtotime('-1 day', strtotime((string)$rowDataEvento['data'])));
                        
                    if(($data_odierna < $data_limite) || ($data_odierna == $data_limite && $ora_odierna <= $rowDataEvento['ora_inizio']) )
                        $sem = 1;
                    else $date_passate++;
                }

                if($sem == 0){
                    $settaConcuso = setData("UPDATE evento SET concluso = 1 WHERE id = '{$id_evento}'");

                    if(!$settaConcuso)
                        return 0;
                    else return 2;
                }
            }
            else {
                $eliminaEvento = setData("DELETE FROM evento WHERE id = '{$id_evento}'");

                if(!$eliminaEvento)
                    return 0;
                else return 2;
            }
            return 1;
        }
        else{

            $eliminaDate = setData("DELETE FROM data_evento WHERE id_evento = '{$id_evento}'");
            if(!$eliminaDate)
                return 0;
            
            $eliminaEvento = setData("DELETE FROM evento WHERE id = '{$id_evento}'");
            if(!$eliminaEvento)
                return 0;

            return 2;
        }
    }

?>