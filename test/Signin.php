<?php
  function Signin($email,$password,$nome,$cognome){
    $resultEmail = getData( "SELECT email FROM utente WHERE email='{$email}'");
    if( $resultEmail != 0){
      if( !empty($resultEmail) ) { return 0;}
    }else return 2;
    //inserimento db
    if( setData( " INSERT INTO utente (nome,cognome,email,password) VALUES ( '{$nome}','{$cognome}','{$email}','{$password}') ")){
      $resultUtente=getData("Select * from utente order by id DESC limit 1");
      $rowUtente=$resultUtente[0];
      $_SESSION['id'] = $rowUtente['id'];
      $_SESSION['nome'] = $rowUtente['nome'];
      $_SESSION['cognome'] = $rowUtente['cognome'];
      $_SESSION['mail'] = $rowUtente['email'];
      $_SESSION['password'] = $password;
      $_SESSION['ruolo'] = $rowUtente['ruolo'];
      $_SESSION['admin'] = 0;
      return 1;
    }else return 2;
  }
?>
