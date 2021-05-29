<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';

require_once 'include/functions/RicercaEventiCategoria.fun.php';

class RicercaEventiCategoriaTest extends TestCase{

    public function test_example(){

      $result = ricercaEventiCategoria("1");
      $this->assertEquals( 1, $result[0]  );
      $result = ricercaEventiCategoria("2");
      $this->assertEquals( 1, $result[0]  );

    }
}

?>
