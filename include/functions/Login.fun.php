<?php
  function Login( $email, $password ){
    $query = "SELECT * FROM utente WHERE email ='{$email}'";
    $resultUtenti = getData( $query );
    if( $resultUtenti == 0 ){
      return 0;
    }

    if( empty($resultUtenti) ){ return 2; }
    else{
      $rowUtente = $resultUtenti[0];
      if( !password_verify( $password, $rowUtente['password'] ) ) { return 2; }
      else{
        $_SESSION['id'] = $rowUtente['id'];
        $_SESSION['nome'] = $rowUtente['nome'];
        $_SESSION['cognome'] = $rowUtente['cognome'];
        $_SESSION['mail'] = $rowUtente['email'];
        $_SESSION['password'] = $password;
        $_SESSION['ruolo'] = $rowUtente['ruolo'];
        $_SESSION['admin'] = 0;
        return 1;
      }
    }

  }

?>
