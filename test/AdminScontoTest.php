<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';

require_once 'include/functions/AdminSconto.fun.php';
class AdminScontoTest extends TestCase{
  
    public function test_example(){

      $this->assertEquals( 1, AdminSconto( "1", "30" ) );
      $this->assertEquals( 1, AdminSconto( "1", "0" ) );

    }
}

?>
