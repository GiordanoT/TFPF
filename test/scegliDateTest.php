<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';

require_once 'include/functions/scegli_date.fun.php';

class scegliDateTest extends TestCase{

    public function test_example(){

      $this->assertEquals( 1, scegliDate(2,array(0,"2021-08-20","2021-08-23"),array(0,"12:00","15:00"),array(0,"13:00","16:00"),array(0,75,75),120) );
      $this->assertEquals( 0, scegliDate(2,array(0,"2021-08-22","2021-08-23"),array(0,"12:00","15:00"),array(0,"10:00","16:00"),array(0,75,75),120) );
      $this->assertEquals( 0, scegliDate(2,array(0,"2021-08-22","2021-08-22"),array(0,"12:00","15:00"),array(0,"13:00","16:00"),array(0,75,75),120) );

      $query = "DELETE FROM evento WHERE nome='Evento Test'";

    }
}

?>
