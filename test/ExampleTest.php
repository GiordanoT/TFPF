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
        $this->assertEquals( Array, ricercaEventi("inte").get_class() );
        $this->assertEquals( Array, ricercaEventi("int").get_class() );
        $this->assertEquals( Array, ricercaEventi("in").get_class() );
        $this->assertEquals( Array, ricercaEventi("i").get_class() );

    }
}
