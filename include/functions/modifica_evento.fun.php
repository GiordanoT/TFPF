<?php

    function ModificaEvento($id_evento, $evento, $date_passate, $date_vecchie, $durata, $giorno, $ora_inizio, $ora_fine, $prezzo_data, $prezzo_totale){
  
        $result_durata_prec= getData("SELECT COUNT(id) AS 'durata' FROM data_evento WHERE id_evento = '{$id_evento}'");
        $durata_precedente = $result_durata_prec[0]['durata']; //numero di date precedenti alla modifica

        //------- Controllo validità dei dati ----------
        for($i = $date_passate+1; $i <= (int)$durata; $i++){
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
            date_default_timezone_set('Europe/Rome');
            $oggi_ora = date("h:i");
            if($giorno[$i] == $oggi && $ora_inizio[$i] < $oggi_ora)
                return 0;
        }
        if((float)$prezzo_totale < 0){
            return 0;
        }
        //------- Fine controllo ---------------

        if($durata <= $durata_precedente){  //se l'utente vuole modificare o eliminare le date tra quelle già registrate

            $resultDateEvento = getData("SELECT * FROM data_evento WHERE id_evento = '{$id_evento}' ORDER BY data ASC");
            $i = 1;
            foreach($resultDateEvento as $rowDataEvento){
                
                if(!(in_array((string)$rowDataEvento['data'],$date_vecchie))){ //Se una data dell'evento non viene elencata nella form per la modifica delle date
                    $id_data = $rowDataEvento['id'];
                    $elimina_data = setData("DELETE FROM data_evento WHERE id = {$id_data}"); //elimino quella data
                    if(!$elimina_data)
                        return 2;
                }
                else{   //se invece viene elencata, eventualmente aggiorno i dati se è stata modificata dall'utente nella form 

                    $modifica_data = setData("UPDATE data_evento SET data = '{$giorno[$i]}', ora_inizio = '{$ora_inizio[$i]}', 
                                              ora_fine = '{$ora_fine[$i]}', costo = '{$prezzo_data[$i]}' WHERE id = {$rowDataEvento['id']}  ");
                    
                    if(!$modifica_data)
                        return 2;
                }
                $i++;
            }
            
            $modifica_dati_evento = setData($evento); //aggiorno i dati dell'evento, nel caso siano stati cambiati dall'utente
            if(!$modifica_dati_evento){
                return 2;
            }
            if($durata == $date_passate){ //se vengono cancellate tutte le date future, setto a concluso l'evento
                $setta_concluso = setData("UPDATE evento SET concluso = 1 WHERE id = {$id_evento}");
                if(!$setta_concluso){
                    return 2;
                }
            }
            return 1;
        }
        else { //se l'utente vuole aggiungere nuove date

            for($i = $date_passate+1; $i <= $durata; $i++){ //inizio a ciclare dalle date ancora non passate
                
                if($i <= $durata_precedente){ //se la data è una di quelle già registrate

                    $result_id_data = getData("SELECT id FROM data_evento WHERE id_evento = '{$id_evento}' 
                                               AND data = '{$date_vecchie[$i]}' ");
                    $id_data = $result_id_data[0]['id'];

                    //aggiorno eventualmente i suoi dati, nel caso siano stati modificati dall'utente
                    $modifica_data = setData("UPDATE data_evento SET data = '{$giorno[$i]}', ora_inizio = '{$ora_inizio[$i]}', 
                                              ora_fine = '{$ora_fine[$i]}', costo = '{$prezzo_data[$i]}' WHERE id = {$id_data}  ");

                    if(!$modifica_data)
                        return 2;
                }
                else{ //se invece la data è del tutto nuova

                    //la inserisco nel database come nuova data
                    $nuova_data = setData("INSERT INTO data_evento (id_evento,data,ora_inizio,ora_fine,costo)
                    VALUES ('{$id_evento}','{$giorno[$i]}','{$ora_inizio[$i]}','{$ora_fine[$i]}', '{$prezzo_data[$i]}')");

                    if(!$nuova_data)
                        return 2;
                }
            }

            if($date_passate == 0){ //se l'evento non ha date che sono già passate

                //aggiorno eventualemente il prezzo complessivo che comprende tutte le date, nel caso sia stato modificato dall'utente
                $result_nuovo_prezzo = setData("UPDATE evento SET costo = '{$prezzo_totale}' WHERE id = {$id_evento}");

                if(!$result_nuovo_prezzo)
                    return 2;
            }


            $modifica_dati_evento = setData($evento); //aggiorno i dati dell'evento, nel caso siano stati modificati dall'utente
            if(!$modifica_dati_evento){
                return 2;
            }

            return 1;
        }
    }
?>