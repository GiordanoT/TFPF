<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'Funzione.php';

class ExampleTest extends TestCase
{

    public function test_example()
    {
        //$this->assertEquals(2, 2);
        $this->assertEquals("false", ricercaEventi("inter"));
        $this->assertEquals("false", ricercaEventi("inter"));
        $this->assertEquals("false", ricercaEventi("inter"));
        $this->assertEquals("false", ricercaEventi("inter"));

    }
}
