<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';

require_once 'include/functions/InserimentoCommento.fun.php';

class InserimentoCommentoTest extends TestCase{

    public function test_example(){

      $this->assertEquals( 1, InserimentoCommento( 15,17,"Test" ) );
      $this->assertEquals( 1, InserimentoCommento( 15,18,"Test2") );

      $result= setData("Delete from commento where id_utente='15'");

      $this->assertEquals( 1, $result );
    }
}

?>