<?php
//require_once( "../include/dbh.inc.php" );
function ricercaEventi( $s ){
	$query = "SELECT * FROM evento WHERE nome LIKE '%{$s}%'";
	$resultEvento = getData( $query );
	return $resultEvento;
}/*
$item = ricercaEventi( "int" );
echo $item.get_class();
$flag = assertEquals( Array(), $item.get_class() );
echo $flag;*/

?>
