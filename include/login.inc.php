<?php
    
    require_once("dbh.inc.php");  
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = addslashes( $email );
    $email = strip_tags( $email );

    $password = addslashes( $password );
    $password = strip_tags( $password );
   
    $query = "SELECT id,nome,cognome,email,password,ruolo FROM utente WHERE email ='".$email."' AND password ='".$password."' ";

    $resultUtenti = getData($query);

    if(count($resultUtenti) != 1)
        header("Location: ../login.php?error=bad_login");
    else{
        session_start();
        foreach($resultUtenti as $rowUtente ){   
            $_SESSION['id'] = $rowUtente['id'];
            $_SESSION['nome'] = $rowUtente['nome'];
            $_SESSION['cognome'] = $rowUtente['cognome'];
            $_SESSION['mail'] = $rowUtente['email'];
            $_SESSION['password'] = $password;
            $_SESSION['ruolo'] = $rowUtente['ruolo'];
        }
        header("Location: ../home.php");
    }
    

?>