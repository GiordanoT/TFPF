<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';

require_once 'Login.php';
require_once 'Signin.php';
require_once 'CategoriaPreferita.php';
require_once 'RicercaEventi.php';
require_once 'EventiCalendarioPref.php';
require_once 'EventiCalendarioPar.php';

class ExampleTest extends TestCase{

    public function test_example(){
      $this->assertEquals( 2, Login( "ciao@ciao.ciao","123" ) );
      $this->assertEquals( 2, Login( "prova@errore.com","1828" ) );
      $this->assertEquals( 1, Login( "mario@mail.it","123" ) );
      $this->assertEquals( 1, Login( "giordano@mail.it","123" ) );

      $this->assertEquals( 0, Signin( "mario@mail.it","123","Mario", "Rossi" ) );
      $this->assertEquals( 0, Signin( "giordano@mail.it","123","Luca", "Rossi" ) );

      $this->assertEquals( 1, modifica_preferiti( 0,"prova@mail.it","123",0 ) );
      $this->assertEquals( 1, modifica_preferiti( 1,"prova@mail.it","123",1 ) );

      $result = ricercaEventi("inter");
      $this->assertEquals( 1, $result[0]  );
      $result = ricercaEventi("roma");
      $this->assertEquals( 1, $result[0]  );

      $result = EventiCalendarioPref( "1900-06-19", 15 );
      $this->assertEquals( 0, $result[0]  );
      $result = EventiCalendarioPref( "2021-05-19", 15 );
      $this->assertEquals( 1, $result[0]  );

      $result = EventiCalendarioPar( "1900-06-19", 15 );
      $this->assertEquals( 0, $result[0]  );
      $result = EventiCalendarioPar( "1981-06-19", 15 );
      $this->assertEquals( 0, $result[0]  );

    }
}

?>
