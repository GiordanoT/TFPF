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
                         id_categoria = '1', posti = '120', immagine = 'image/evento/francavilla-tollo.jpg', citta = 'Francavilla Al Mare' 
                         WHERE id = '19' ";
        

        $this->assertEquals( 1, ModificaEvento(19,$query_evento_1,1,array(0,"2021-05-20","2021-09-10"),2,array(0,"2021-05-20","2021-09-11"),array(0,"18:00","09:00"),array(0,"21:00","11:00"),array(0,0,30),120));
        $this->assertEquals( 1, ModificaEvento(19,$query_evento_1,1,array(0,"2021-05-20","2021-09-11",""),3,array(0,"2021-05-20","2021-09-11","2021-09-14"),array(0,"18:00","16:00","10:00"),array(0,"21:00","17:00","11:00"),array(0,0,30,30),120));
        $this->assertEquals( 0, ModificaEvento(19,$query_evento_1,1,array(0,"2021-05-20","2021-09-11","2021-09-14"),3,array(0,"2021-05-20","2021-09-11","2021-09-14"),array(0,"18:00","16:00","10:00"),array(0,"21:00","17:00","09:00"),array(0,0,30,30),120));
        $this->assertEquals( 1, ModificaEvento(19,$query_evento_1,1,array(0,"2021-05-20","2021-09-11"),2,array(0,"2021-05-20","2021-09-11"),array(0,"18:00","16:00"),array(0,"21:00","17:00"),array(0,0,30),120));
        $this->assertEquals( 1, ModificaEvento(19,$query_evento_1,1,array(0,"2021-05-20"),1,array(0,"2021-05-20"),array(0,"18:00"),array(0,"21:00"),array(0,0),120));
     
        $query = "DELETE FROM evento WHERE nome='Evento Test'";
        $this->assertEquals( 1, setData( $query ) );
    }
}

?>