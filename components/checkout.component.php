<?php
  require_once( "dbh.inc.php" );
  $array = array();
  for($i=0; $i<=6; $i++){
    if( ! isset($_GET[$i]) ){
      break;
    } else {
      array_push( $array, $_GET[$i] );
    }
  }
  var_dump($array);
  
?>
