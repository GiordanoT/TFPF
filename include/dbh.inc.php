<?php
  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING) );
  $db = 1;
  if( $db == 0 ){
    //DB ONLINE
    $servername = "sql11.freesqldatabase.com";
    $dBUsername = "sql11417527";
    $dBPassword = "cpbdqdiIf3";
    $dBName = "sql11417527";
  } else {
    //DB LOCALE
    $servername = "localhost";
    $dBUsername = "root";
    $dBPassword = "";
    $dBName = "globex_corporation";
  }


  function getData( $sql ){
    $connection = mysqli_connect( $GLOBALS['servername'], $GLOBALS['dBUsername'], $GLOBALS['dBPassword'], $GLOBALS['dBName'] );
    if( !$connection ){
      return 0;
    }
    $stmt = mysqli_stmt_init( $connection );
    if( !mysqli_stmt_prepare( $stmt, $sql ) ) {
      return 0;
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
      return 0;
    }
    $stmt = mysqli_stmt_init( $connection );
    if ( !mysqli_stmt_prepare( $stmt, $sql ) ) {
      return 0;
    }
    mysqli_stmt_execute( $stmt );
    return 1;
  }
?>
