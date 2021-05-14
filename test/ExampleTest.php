<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'Funzione.php';
require_once '/include/dbh.inc.php';

class ExampleTest extends TestCase
{

    public function test_example()
    {
        $this->assertEquals(true,login("gianluca@mail.it","123"));
        $this->assertEquals(false,login("margherita@mail.it","125"));
        $this->assertEquals(false,login("davide@mail.it","123"));
        $this->assertEquals(false,login("","125"));
        $this->assertEquals(false,login("gianluca@mail.it",""));
    }
}

?>