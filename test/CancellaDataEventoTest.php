<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';

require_once 'include/functions/CancellaData.fun.php';

class CancellaDataEventoTest extends TestCase{

    public function test_example(){

      $query = 'INSERT INTO evento(id, nome, descrizione, id_categoria, tipologia, posti, admin_evento, costo, immagine, citta, concluso, approvato, sconto) VALUES (1,\'Evento Test\',\'\',1,1,100,15,0,\'\',\'Roma\',0,1,0)';
      $this->assertEquals( 1, setData( $query ) );

      $query = 'INSERT INTO data_evento(id, id_evento, data, ora_inizio, ora_fine, costo) VALUES (1,1,\'2050-01-01\',\'18:00:00\',\'20:00:00\',30)';
      $this->assertEquals( 1, setData( $query ) );

      $this->assertEquals( 1, CancellaData( 1,1 ) );
      $this->assertEquals( 2, CancellaData( 0,1 ) );

      $query = "DELETE FROM evento WHERE id = 1 ";
      $this->assertEquals( 1, setData( $query ) );
    }
}

?>
