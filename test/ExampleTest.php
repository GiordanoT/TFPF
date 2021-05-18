<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';

class ExampleTest extends TestCase{

    public function test_example(){
      $query = "INSERT INTO categoria (nome,immagine) VALUES ('rugby','rugby')";
      $this->assertEquals( 1, setData( $query ) );
      $this->assertEquals( 1, setData( $query ) );
    }
}

?>
