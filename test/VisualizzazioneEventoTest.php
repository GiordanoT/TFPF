<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';

require_once 'include/functions/VisualizzazioneEvento.fun.php';

class VisualizzazioneEventoTest extends TestCase{

    public function test_example(){

      $this->assertEquals( 0, VisualizzazioneEvento(10000) );
      $this->assertEquals( 0, VisualizzazioneEvento(10001) );
    }
}

?>