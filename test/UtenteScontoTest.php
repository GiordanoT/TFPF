<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';

require_once 'include/functions/UtenteSconto.fun.php';

class UtenteScontoTest extends TestCase{

    public function test_example(){

      $this->assertEquals( 1, UtenteSconto( "19", "30" ) );
      $this->assertEquals( 1, UtenteSconto( "19", "0" ) );

    }
}

?>
