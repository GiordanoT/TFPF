<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once './vendor/autoload.php';
require_once 'Funzione.php';
require_once 'include/dbh.inc.php';

class ExampleTest extends TestCase
{

    public function test_example(){

        //$this->assertEquals(2, 2);
        //registrazione($email,$password,$nome,$cognome)
        //modifica_preferiti($cat,$mail,$del)

        //$this->assertEquals( 2, modifica_preferiti('db','db','db') );
        $this->assertEquals( 1, modifica_preferiti('2','giordano@mail.it','0'));
        $this->assertEquals( 1, modifica_preferiti('2','giordano@mail.it','1'));
        $this->assertEquals( 0, modifica_preferiti('1','giordano@mail.it','1'));
        $this->assertEquals( 0, registrazione('giordano@mail.it','123','prova','prova'));
        $this->assertEquals( 1, registrazione('test@test','123','prova','prova'));
        //$this->assertEquals( 2, registrazione('db','db','db','db'));
    
    
    }
}