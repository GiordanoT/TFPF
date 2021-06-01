<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';

require_once 'include/functions/VisualizzaBiglietto.fun.php';
class TicketTest extends TestCase{

    public function test_example(){

      $this->assertEquals( 0, VisualizzaBiglietto( "1234" ) );
      $this->assertEquals( 0, VisualizzaBiglietto( "5678" ) );
      $this->assertEquals( 0, VisualizzaBiglietto( "1111" ) );

      $result = VisualizzaBiglietto( "89778235119620683988" )

      $this->assertEquals( "89778235119620683988", $result[7] );
      $this->assertEquals( "Mario Gialli", $result[6] );
      $this->assertEquals( "Francavilla-Tollo", $result[3] );

    }
}

?>
