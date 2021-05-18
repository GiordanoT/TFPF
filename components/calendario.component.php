<?php
  error_reporting(E_ALL ^ (E_WARNING | E_NOTICE));


	require_once('include\dbh.inc.php');
	$template = new Template( 'templates/calendario.template.html' );
  date_default_timezone_set("Europe/Rome");
  if(!isset($_GET["mese"]) || !isset($_GET["anno"]) ){
    $anno = date('Y');
    $monthNumber = date('m');
    $monthNumber--;
  }
  else {
    $anno = $_GET["anno"];
    $monthNumber = $_GET["mese"];
    if( $monthNumber < 0 || $monthNumber > 11 ){
      require( "components/error.component.php" );
      require( "components/footer.component.php" );
      exit();
    }
  }
  if(isset($_POST["meno"])){
    if($monthNumber == 0){
       $anno--;
       $monthNumber = 11;
    } else {
      $monthNumber = ($monthNumber-1)%12;
    }
  }
  if(isset($_POST["piu"])){
    if($monthNumber == 11){
       $anno++;
       $monthNumber = 0;
    } else {
      $monthNumber = ($monthNumber+1)%12;

    }

  }
  $template -> setContent("URL_DATA_CALENDARIO", "anno={$anno}&mese={$monthNumber}");

  switch ( $monthNumber ) {
    case 0:
        $mese = "Gennaio";
        $meseTitle ="Jan";
        $endMonth = 31;
      break;
      case 1:
        $mese = "Febbraio";
        $meseTitle ="Feb";
        if($anno % 4 == 0)
          $endMonth = 29;
        else
          $endMonth = 28;
      break;
      case 2:
        $mese = "Marzo";
        $meseTitle ="Mar";
        $endMonth = 31;
      break;
      case 3:
        $mese = "Aprile";
        $meseTitle ="Apr";
        $endMonth = 30;
      break;
      case 4:
        $mese = "Maggio";
        $meseTitle ="May";
        $endMonth = 31;
      break;
      case 5:
        $mese = "Giugno";
        $meseTitle ="Jun";
        $endMonth = 30;
      break;
      case 6:
        $mese = "Luglio";
        $meseTitle ="Jul";
        $endMonth = 31;
      break;
      case 7:
        $mese = "Agosto";
        $meseTitle ="Aug";
        $endMonth = 31;
      break;
      case 8:
        $mese = "Settembre";
        $meseTitle ="Sep";
        $endMonth = 30;
      break;
      case 9:
        $mese = "Ottobre";
        $meseTitle ="Oct";
        $endMonth = 31;
      break;
      case 10:
        $mese = "Novembre";
        $meseTitle ="Nov";
        $endMonth = 30;
      break;
      case 11:
        $mese = "Dicembre";
        $meseTitle ="Dec";
        $endMonth = 31;
      break;
  }
   $template -> setContent("MESE",$mese);
   $template -> setContent("ANNO",$anno);


  $firstDay = strtotime( $meseTitle." 1 ".$anno);
  $firstDay= date("D", $firstDay);
  switch ($firstDay) {
    case 'Mon':
      for( $i=1; $i<$endMonth+1; $i++ ){
        $template -> setContent( 'WEEK_'.$i, $i );
        $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
        $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
      }
      for( $i=$endMonth+1; $i<43; $i++ ){
        $template -> setContent( 'WEEK_'.$i, "" );
        $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
        $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
      }
    break;

    case 'Tue':
      $template -> setContent( 'WEEK_1', "" );
      $template -> setContent( 'EVENTO_WEEK_1', "" );
      $template -> setContent( 'FLAG_WEEK_1', "d-none" );
      for( $i=2; $i<$endMonth+2; $i++ ){
        $template -> setContent( 'WEEK_'.$i, $i-1 );
        $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
        $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
      }
      for( $i=$endMonth+1; $i<43; $i++ ){
        $template -> setContent( 'WEEK_'.$i, "" );
        $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
        $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
      }
    break;

    case 'Wed':
      for( $i=1; $i<3; $i++ ){
        $template -> setContent( 'WEEK_'.$i, "" );
        $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
        $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
      }
      for( $i=3; $i<$endMonth+3; $i++ ){
        $template -> setContent( 'WEEK_'.$i, $i-2 );
        $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
        $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
      }
      for( $i=$endMonth+1; $i<43; $i++ ){
        $template -> setContent( 'WEEK_'.$i, "" );
        $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
        $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
      }
    break;

    case 'Thu':
      for( $i=1; $i<4; $i++ ){
        $template -> setContent( 'WEEK_'.$i, "" );
        $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
        $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
      }
      for( $i=4; $i<$endMonth+4; $i++ ){
        $template -> setContent( 'WEEK_'.$i, $i-3 );
        $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
        $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
      }
      for( $i=$endMonth+1; $i<43; $i++ ){
        $template -> setContent( 'WEEK_'.$i, "" );
        $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
        $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
      }
    break;

    case 'Fri':
      for( $i=1; $i<5; $i++ ){
        $template -> setContent( 'WEEK_'.$i, "" );
        $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
        $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
      }
      for( $i=5; $i<$endMonth+5; $i++ ){
        $template -> setContent( 'WEEK_'.$i, $i-4 );
        $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
        $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
      }
      for( $i=$endMonth+1; $i<43; $i++ ){
        $template -> setContent( 'WEEK_'.$i, "" );
        $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
        $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
      }
    break;

    case 'Sat':
      for( $i=1; $i<6; $i++ ){
        $template -> setContent( 'WEEK_'.$i, "" );
        $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
        $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
      }
      for( $i=6; $i<$endMonth+6; $i++ ){
        $template -> setContent( 'WEEK_'.$i, $i-5 );
        $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
        $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
      }
      for( $i=$endMonth+1; $i<43; $i++ ){
        $template -> setContent( 'WEEK_'.$i, "" );
        $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
        $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
      }
    break;

    case 'Sun':
      for( $i=1; $i<7; $i++ ){
        $template -> setContent( 'WEEK_'.$i, "" );
        $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
        $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
      }
      for( $i=7; $i<$endMonth+7; $i++ ){
        $template -> setContent( 'WEEK_'.$i, $i-6 );
        $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
        $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
      }
      for( $i=$endMonth+1; $i<43; $i++ ){
        $template -> setContent( 'WEEK_'.$i, "" );
        $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
        $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
      }
    break;
}




	$template -> close();
?>
