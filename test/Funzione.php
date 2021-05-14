<?php

function ricercaEventi( $s ){
	$query = "SELECT * FROM evento WHERE nome LIKE '%{$s}%'";
	$resultEvento = getData( $query );
	return $resultEvento;
}

?>
