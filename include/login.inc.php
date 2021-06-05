<?php
    session_start();
    require_once("dbh.inc.php");
    require_once("functions/Login.fun.php");
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





?>
