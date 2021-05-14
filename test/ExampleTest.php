<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'Funzione.php';

class ExampleTest extends TestCase
{

    public function test_example()
    {
        $this->assertEquals(true,"gianluca@mail.it","123");
        $this->assertEquals(false,"margherita@mail.it","125");
        $this->assertEquals(false,"davide@mail.it","123");
        $this->assertEquals(false,"","125");
        $this->assertEquals(false,"gianluca@mail.it","");
    }
}