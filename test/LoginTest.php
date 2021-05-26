<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'include/dbh.inc.php';

require_once 'Login.php';
require_once 'Signin.php';
require_once 'CategoriaPreferita.php';
require_once 'RicercaEventi.php';
require_once 'RicercaEventiCategoria.php';
require_once 'EventiCalendarioPref.php';
require_once 'EventiCalendarioPar.php';
require_once 'CreaEvento.php';
require_once 'ScegliDate.php';
require_once 'Functions/AdminSconto.php';
require_once 'Functions/UtenteSconto.php';


class ExampleTest extends TestCase{

    public function login_test(){
      $this->assertEquals( 2, Login( "ciao@ciao.ciao","123" ) );
      $this->assertEquals( 2, Login( "prova@errore.com","1828" ) );
      $this->assertEquals( 1, Login( "mario@mail.it","123" ) );
      $this->assertEquals( 1, Login( "giordano@mail.it","123" ) );
    }
}

?>
