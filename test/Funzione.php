<?php
	function setData( $sql ){
		$connection = mysqli_connect( "localhost", "root", "", "globex_corporation" );
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
