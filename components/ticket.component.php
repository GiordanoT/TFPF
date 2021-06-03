<?php
	require_once( "include/dbh.inc.php" );
	require_once( "include/functions/VisualizzaBiglietto.fun.php" );

	session_start();
	$template = new Template( 'templates/ticket.template.html' );
	$result = VisualizzaBiglietto( $_GET['id'] );
	if ( $result == 0 ){
		require( "components/error.component.php" );
		require( "components/footer.component.php" );
		exit();
	}
	$data = $result[0];
	$anno = $data[0].$data[1].$data[2].$data[3];
	$monthNumber = $data[5].$data[6];
	$giorno = $data[8].$data[9];
	switch ( $monthNumber ) {
		case 0:
				$mese = "Gennaio";
				$meseTitle ="Jan";
			break;
			case 1:
				$mese = "Febbraio";
				$meseTitle ="Feb";
			break;
			case 2:
				$mese = "Marzo";
				$meseTitle ="Mar";
			break;
			case 3:
				$mese = "Aprile";
				$meseTitle ="Apr";
			break;
			case 4:
				$mese = "Maggio";
				$meseTitle ="May";
			break;
			case 5:
				$mese = "Giugno";
				$meseTitle ="Jun";
			break;
			case 6:
				$mese = "Luglio";
				$meseTitle ="Jul";
			break;
			case 7:
				$mese = "Agosto";
				$meseTitle ="Aug";
			break;
			case 8:
				$mese = "Settembre";
				$meseTitle ="Sep";
			break;
			case 9:
				$mese = "Ottobre";
				$meseTitle ="Oct";
			break;
			case 10:
				$mese = "Novembre";
				$meseTitle ="Nov";
			break;
			case 11:
				$mese = "Dicembre";
				$meseTitle ="Dec";
			break;
	}
	$giorno_settimana = strtotime( $meseTitle." ".$giorno." ".$anno);
	$giorno_settimana= date("D", $giorno_settimana);
	switch ( $giorno_settimana ) {
    case 'Mon':
      $giorno_settimana = "Lunedi";
    break;

    case 'Tue':
			$giorno_settimana = "Martedi";
    break;

    case 'Wed':
			$giorno_settimana = "Mercoledi";
    break;

    case 'Thu':
			$giorno_settimana = "Giovedi";
    break;

    case 'Fri':
			$giorno_settimana = "Venerdi";
    break;

    case 'Sat':
			$giorno_settimana = "Sabato";
    break;

    case 'Sun':
			$giorno_settimana = "Domenica";
    break;
	}

	$template -> setContent( "GIORNO", $giorno );
	$template -> setContent( "MESE", $mese );
	$template -> setContent( "ANNO", $anno );
	$template -> setContent( "CATEGORIA", $result[1] );
	$template -> setContent( "LUOGO", $result[2] );
	$template -> setContent( "TITOLO", $result[3] );
	$template -> setContent( "INIZIO", $result[4] );
	$template -> setContent( "FINE", $result[5] );
	$template -> setContent( "GIORNO_SETTIMANA", $giorno_settimana );
	$template -> setContent( "CODICE", $result[7] );
	$template -> setContent( "INTESTATARIO", $result[6] );
	$template -> close();
?>
