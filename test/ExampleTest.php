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
        $this->assertEquals( 0, ricercaEventi("inter") );
        $this->assertEquals( 0, ricercaEventi("inte") );
        $this->assertEquals( 0, ricercaEventi("int") );
        $this->assertEquals( 0, ricercaEventi("in") );
        $this->assertEquals( 0, ricercaEventi("i") );
        $this->assertEquals( 0, ricercaEventi("") );
        $this->assertEquals( 0, ricercaEventi("mila") );
        $this->assertEquals( 0, ricercaEventi("juve") );
    }
}
