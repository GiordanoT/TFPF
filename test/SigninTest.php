<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';


require_once 'include/functions/Signin.fun.php';

class SigninTest extends TestCase{

    public function test_example(){

      $this->assertEquals( 0, Signin( "mario@mail.it","123","Mario", "Rossi" ) );
      $this->assertEquals( 0, Signin( "giordano@mail.it","123","Luca", "Rossi" ) );

    }
}

?>
