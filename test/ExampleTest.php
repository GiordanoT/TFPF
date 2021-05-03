<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
//require_once './Funzione.php';

 function somma($n){
    return $n+1;
} 

class ExampleTest extends TestCase
{

    public function test_example()
    {
        //$this->assertEquals(2, 2);
        $this->assertEquals(4, somma(3));
    }
}