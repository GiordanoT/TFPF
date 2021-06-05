<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';

require_once 'include/functions/EventiCalendarioPar.fun.php';

class EventiCalendarioParTest extends TestCase{

    public function test_example(){

      $result = EventiCalendarioPar( "1900-06-19", 15 );
      $this->assertEquals( 0, $result[0]  );
      $result = EventiCalendarioPar( "1981-06-19", 15 );
      $this->assertEquals( 0, $result[0]  );

    }
}

?>
