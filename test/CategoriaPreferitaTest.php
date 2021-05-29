<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';

require_once 'include/functions/CategoriaPreferita.fun.php';

class CategoriaPreferitaTest extends TestCase{

    public function test_example(){

      $this->assertEquals( 1, modifica_preferiti( 0,"prova@mail.it","123",0 ) );
      $this->assertEquals( 1, modifica_preferiti( 1,"prova@mail.it","123",1 ) );

    }
}

?>
