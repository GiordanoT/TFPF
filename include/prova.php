<?php
  require_once( "dbh.inc.php" );
  $resultUtente = getData( "SELECT * FROM utente" );
  foreach( $resultUtente as $rowUtente ){
    $nome = $rowUtente['nome'];
    $cognome = $rowUtente['cognome'];
    echo $nome." ".$cognome;
    echo "<br>";
  }
  setData( "INSERT INTO utente (nome,cognome,email,password) VALUES (1,1,1,1)" )
?>
