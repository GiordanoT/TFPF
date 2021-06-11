<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';

require_once 'include/dbh.inc.php';
require_once 'include/functions/EsistenzaData.fun.php';

class EsistenzaData extends TestCase{



    public function test_example(){
        $query = "INSERT INTO evento(id, nome, descrizione, id_categoria, tipologia, posti, admin_evento, costo, immagine, citta, concluso, approvato, sconto) VALUES (1,'Evento Test','',1,1,100,15,0,'','Roma',0,1,0)";
        $this->assertEquals( 1, setData( $query ) );
        
        $query = "INSERT INTO data_evento(id, id_evento, data, ora_inizio, ora_fine, costo) VALUES (1,1,'2050-01-01','18:00:00','20:00:00',30)";
        $this->assertEquals( 1, setData( $query ) );
        
        $this->assertEquals( 1, EsistenzaData(1) );
  
        $query = "INSERT INTO evento(id, nome, descrizione, id_categoria, tipologia, posti, admin_evento, costo, immagine, citta, concluso, approvato, sconto) VALUES (2,'Evento Test','',1,1,100,15,0,'','Roma',0,1,0)";
        $this->assertEquals( 1, setData( $query ) );
        
        $this->assertEquals( 0, EsistenzaData(2) );

        $query = "DELETE FROM evento WHERE nome='Evento Test' ";
        $this->assertEquals( 1, setData( $query ) );

        $query = "DELETE FROM data_evento WHERE id='1' ";
        $this->assertEquals( 1, setData( $query ) );

      
    }

}

?>
