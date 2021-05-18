<?php
  function Login( $email, $password ){
    $query = "SELECT * FROM utente WHERE email ='{$email}'";
    $resultUtenti = getData( $query );
    if( $resultUtenti == 0 ){
      return 0;
    }
    $rowUtente = $resultUtenti[0];
    if( empty($rowUtente) ){ return 2; }
    else{      
      if( !password_verify( $password, $rowUtente['password'] ) ) { return 2; }
      else{
        session_start();
        $_SESSION['id'] = $rowUtente['id'];
        $_SESSION['nome'] = $rowUtente['nome'];
        $_SESSION['cognome'] = $rowUtente['cognome'];
        $_SESSION['mail'] = $rowUtente['email'];
        $_SESSION['password'] = $password;
        $_SESSION['ruolo'] = $rowUtente['ruolo'];
        return 1;
      }
    }

  }

?>
