<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';

require_once 'Login.php';

class ExampleTest extends TestCase{

    public function test_example(){
      $this->assertEquals( 2, Login( "prova@mail.it","123" ) );
      //$this->assertEquals( 1, Login( $query ) );
      //$this->assertEquals( 2, Login( $query ) );
      //$this->assertEquals( 2, Login( $query ) );
    }
}

?>
