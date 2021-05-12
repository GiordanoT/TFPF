<?php
  error_reporting(E_ALL ^ E_ALL);
  $servername = "localhost";
  $dBUsername = "root";
  $dBPassword = "";
  $dBName = "globex_corporation";

  function getData( $sql ){
    $connection = mysqli_connect( $GLOBALS['servername'], $GLOBALS['dBUsername'], $GLOBALS['dBPassword'], $GLOBALS['dBName'] );
    if( !$connection ){
      return "false";
      //header("Location: ../error.php");
	    //require 'component/error.component.php';
      exit();
    }
    $stmt = mysqli_stmt_init( $connection );
    if( !mysqli_stmt_prepare( $stmt, $sql ) ) {
      return "false";
      //header( "Location: ../error.php" );
	    //require 'component/error.component.php';
      exit();
    }
    $queryResult = array();
    mysqli_stmt_execute( $stmt);
    $result = mysqli_stmt_get_result( $stmt );
    while( $row = mysqli_fetch_assoc( $result ) ){
      array_push( $queryResult, $row );
    }
    mysqli_close( $connection );
    return $queryResult;
  }

  function setData( $sql ){
    $connection = mysqli_connect( $GLOBALS['servername'], $GLOBALS['dBUsername'], $GLOBALS['dBPassword'], $GLOBALS['dBName'] );
    if( !$connection ){
      return "false";
      //header( "Location: ../error.php" );
	    //require 'component/error.component.php';
      exit();
    }
    $stmt = mysqli_stmt_init( $connection );
    if ( !mysqli_stmt_prepare( $stmt, $sql ) ) {
      return "false";
      //header( "Location: ../error.php" );
	    //require 'component/error.component.php';
      exit();
    }
    mysqli_stmt_execute( $stmt );
    return true;
  }
?>
