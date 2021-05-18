<?php
    require_once("dbh.inc.php");
    if( !isset($_POST['login']) ){
      header("Location: ../login.php");
      exit();
    }
    $email = $_POST['email'];
    $email = addslashes( $email );
    $email = strip_tags( $email );
    $password = $_POST['password'];
    $result = Login( $email, $password );
    if( $result == 0 ){
      header("Location: error.php");
      exit();
    }
    if( $result == 1 ) {
      header("Location: ../home.php");
      exit();
    }
    if( $result == 2 ) {
      header( "Location: ../login.php?error=bad_login" );
      exit();
    }


    function Login( $email, $password ){
      $query = "SELECT * FROM utente WHERE email ='{$email}'";
      $resultUtenti = getData( $query );
      if( $resultUtenti == 0 ){
        return 0;
      }
      $rowUtente = $resultUtenti[0];
      if( empty($rowUtente) || !password_verify( $password, $rowUtente['password'] ) ) { return 2; }
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


?>
