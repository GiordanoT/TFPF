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
        $this->assertEquals(4, somma(3));
        $this->assertEquals(2, somma(1));
        $this->assertEquals(3, somma(2));
        $this->assertEquals(5, somma(4));

    }
}