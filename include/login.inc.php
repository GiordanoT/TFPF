<?php

    require_once("dbh.inc.php");

    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = addslashes( $email );
    $email = strip_tags( $email );


    $query = "SELECT * FROM utente WHERE email ='{$email}'";
    $resultUtenti = getData($query);
    if( $resultUtenti == 0 ){
      header("Location: error.php");
    }

    $rowUtente = $resultUtenti[0];
    if( empty($rowUtente) || !password_verify( $password, $rowUtente['password'] ) ){
      header( "Location: ../login.php?error=bad_login" );
      exit();
    }
    else{
        session_start();
        $_SESSION['id'] = $rowUtente['id'];
        $_SESSION['nome'] = $rowUtente['nome'];
        $_SESSION['cognome'] = $rowUtente['cognome'];
        $_SESSION['mail'] = $rowUtente['email'];
        $_SESSION['password'] = $password;
        $_SESSION['ruolo'] = $rowUtente['ruolo'];
        header("Location: ../home.php");
        exit();
    }


?>
