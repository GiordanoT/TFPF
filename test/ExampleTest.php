<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';

require_once 'Login.php';
require_once 'Signin.php';

class ExampleTest extends TestCase{

    public function test_example(){
      $this->assertEquals( 2, Login( "ciao@ciao.ciao","123" ) );
      $this->assertEquals( 2, Login( "prova@errore.com","1828" ) );
      $this->assertEquals( 1, Login( "giordano@mail.it","123" ) );
      $this->assertEquals( 1, Login( "mario@mail.it","123" ) );
      $this->assertEquals( 0, Signin( "giordano@mail.it","123","Luca","Rossi" ) );
      $this->assertEquals( 0, Signin( "mario@mail.it","123","Mario", "Rossi" ) );

    }
}

?>
