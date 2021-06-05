<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';

require_once 'include/functions/RicercaEventi.fun.php';

class RicercaEventiTest extends TestCase{

    public function test_example(){

      $result = ricercaEventi("inter");
      $this->assertEquals( 1, $result[0]  );
      $result = ricercaEventi("roma");
      $this->assertEquals( 1, $result[0]  );

    }
}

?>
