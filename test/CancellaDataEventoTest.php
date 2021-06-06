<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';

require_once 'include/functions/CancellaData.fun.php';

class CancellaDataEventoTest extends TestCase{

    public function test_example(){

        $this->assertEquals( 1, CancellaData(208,165) );
        $this->assertEquals( 2, CancellaData(0,165) );

        $query = "DELETE FROM evento WHERE nome='Evento Test'";
        $this->assertEquals( 1, setData( $query ) );
    }
}

?>
