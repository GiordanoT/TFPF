<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';

require_once 'include/functions/ApprovaEvento.fun.php';
class ApprovaEventoTest extends TestCase{
  
    public function test_example(){

      $this->assertEquals( 1, ApprovaEvento( "23", 1 ) );
      $this->assertEquals( 1, ApprovaEvento( "23", 0 ) );
      $this->assertEquals( 0, ApprovaEvento( "23", 5 ) );

    }
}

?>