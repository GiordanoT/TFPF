<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';

require_once 'include/functions/crea_evento.fun.php';

class CreaEventoTest extends TestCase{

    public function test_example(){
      
      $this->assertEquals( 1, creaEvento("Evento Test","F1 - GP di Monaco",0,2,12000,13,150.00,"foto.jpg","Monaco",0,2) );
      $this->assertEquals( 0, creaEvento("Evento Test","F1 - GP di Monaco",1,2,0,13,150.00,"foto.jpg","Monaco",0,2) );
      $this->assertEquals( 0, creaEvento("Evento Test","F1 - GP di Monaco",1,2,12000,13,-150.00,"foto.jpg","Monaco",0,2) );

      $query = "DELETE FROM evento WHERE nome='Evento Test'";
      $this->assertEquals( 1, setData( $query ) );
    }
}
?>