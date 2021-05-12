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
        $this->assertEquals("false", ricercaEventi("inte"));
        $this->assertEquals("false", ricercaEventi("int"));
        $this->assertEquals("false", ricercaEventi("in"));
        $this->assertEquals("false", ricercaEventi("i"));

    }
}
