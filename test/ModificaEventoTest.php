<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';

require_once 'include/functions/modifica_evento.fun.php';

class ModificaEventoTest extends TestCase{

    public function test_example(){
        
        $query_evento_1 = "UPDATE evento  
                         SET nome = 'Francavilla-Tollo', descrizione = 'Settima giornata di Serie A', tipologia = '0', 
                         id_categoria = '1', posti = '50', immagine = 'image/evento/francavilla-tollo.jpg', citta = 'Francavilla Al Mare' 
                         WHERE id = '19' ";
        
        $query_evento_0 = "UPDATE evento  
                         SET nome = 'Francavilla-Tollo', descrizione = 'Settima giornata di Serie A', tipologia = '0', 
                         id_categoria = '1', posti = '-10', immagine = 'image/evento/francavilla-tollo.jpg', citta = 'Francavilla Al Mare' 
                         WHERE id = '19' ";
      
        $this->assertEquals( 1, ModificaEvento(19,$query_evento_1,1,array(0,"2021-05-20","2021-05-30"),2,array(0,"2021-05-20","2021-05-31"),array(0,"18:00","9:00"),array(0,"21:00","10:00"),array(0,0,30),120));
        $this->assertEquals( 1, ModificaEvento(19,$query_evento_1,1,array(0,"2021-05-20","2021-05-31"),3,array(0,"2021-05-20","2021-05-30","2021-06-01"),array(0,"18:00","9:00","10:00"),array(0,"21:00","10:00","11:00"),array(0,0,30,30),120));
        $this->assertEquals( 0, ModificaEvento(19,$query_evento_1,1,array(0,"2021-05-20","2021-05-30","2021-06-01"),3,array(0,"2021-05-20","2021-05-31","2021-06-01"),array(0,"18:00","9:00","10:00"),array(0,"21:00","10:00","9:00"),array(0,0,30,30),120));
        $this->assertEquals( 0, ModificaEvento(19,$query_evento_0,1,array(0,"2021-05-20","2021-05-30","2021-06-01"),3,array(0,"2021-05-20","2021-05-31","2021-06-01"),array(0,"18:00","9:00","10:00"),array(0,"21:00","10:00","11:00"),array(0,0,30,30),120));
        $this->assertEquals( 1, ModificaEvento(19,$query_evento_1,1,array(0,"2021-05-20","2021-05-31","2021-06-01"),2,array(0,"2021-05-20","2021-05-30"),array(0,"18:00","9:00"),array(0,"21:00","10:00"),array(0,0,30),120));
        $this->assertEquals( 1, ModificaEvento(19,$query_evento_1,1,array(0,"2021-05-20","2021-05-30"),1,array(0,"2021-05-20"),array(0,"18:00"),array(0,"21:00"),array(0,0),120));
     
        $query = "DELETE FROM evento WHERE nome='Evento Test'";
        $this->assertEquals( 1, setData( $query ) );
    }
}

?>