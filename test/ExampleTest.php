<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
//require_once './Funzione.php';


class ExampleTest extends TestCase
{
    public function somma($n){
        return $n+1;
    }

    public function test_example()
    {
        $n = (Object) 0;
        //$this->assertEquals(2, 2);
        $n-> somma(3);
        $this->assertEquals(4, $n);
    }
}