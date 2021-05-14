<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';

require_once( "Funzione.php" );
require_once( "include/dbh.inc.php" );

class ExampleTest extends TestCase
{

    public function test_example()
    {
        //$this->assertEquals(2, 2);
        $this->assertEquals(!0, ricercaEventi("inte"));
        $this->assertEquals(!0, ricercaEventi("int"));
        $this->assertEquals(!0, ricercaEventi("in"));
        $this->assertEquals(!0, ricercaEventi("i"));

    }
}
