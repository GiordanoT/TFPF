<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';


class ExampleTest extends TestCase
{
    public function test_example()
    {
        $this->assertEquals(1, 1);
    }
}