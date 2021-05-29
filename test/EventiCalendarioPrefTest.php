<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';

require_once 'include/functions/EventiCalendarioPref.fun.php';

class EventiCalendarioPrefTest extends TestCase{

    public function test_example(){

      $result = EventiCalendarioPref( "1900-06-19", 15 );
      $this->assertEquals( 0, $result[0]  );
      $result = EventiCalendarioPref( "2021-05-19", 15 );
      $this->assertEquals( 1, $result[0]  );

    }
}

?>
