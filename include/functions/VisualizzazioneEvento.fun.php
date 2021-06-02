<?php

function VisualizzazioneEvento($evento){
    $risultatoEvento = getData("SELECT e.sconto as sconto, e.id_categoria as e_idc, e.id as idevento, e.id_categoria as idcat, e.immagine as eveimmagine, c.immagine as catimmagine, e.nome as titolo, e.citta as citta, e.costo as prezzo,
		e.posti as posti, e.descrizione as descrizione, c.nome as nomecat FROM evento as e join categoria as c on (e.id_categoria = c.id ) where e.id ='{$evento}' ");


    if($risultatoEvento == 0 || empty($risultatoEvento)){
        return 0;
      }else {
        return $risultatoEvento[0];
    }
}

?>
